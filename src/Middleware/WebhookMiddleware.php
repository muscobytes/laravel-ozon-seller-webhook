<?php

namespace Muscobytes\OzonSeller\Middleware;

use Closure;
use Illuminate\Http\Request;
use Muscobytes\OzonSeller\Events\NewPostingEvent;
use Muscobytes\OzonSeller\Events\PingEvent;
use Muscobytes\OzonSeller\Exceptions\MessageFactoryException;
use Muscobytes\OzonSeller\Exceptions\WebhookException;
use Muscobytes\OzonSeller\MessageFactory;
use Muscobytes\OzonSeller\Messages\NewPostingMessage;
use Muscobytes\OzonSeller\Messages\PingMessage;
use Spatie\LaravelData\Data;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;


class WebhookMiddleware
{
    private array $events = [
        PingMessage::class                  => PingEvent::class,
        NewPostingMessage::class            => NewPostingEvent::class,
//            PostingCanceledMessage::class       => PostingCanceledEvent::class,
//            StateChangedMessage::class          => StateChangedEvent::class,
//            CutoffDateChangedMessage::class     => CutoffDateChangedEvent::class,
//            DeliveryDateChangedMessage::class   => DeliveryDateChangedEvent::class,
//            CreateItemMessage::class            => CreateItemEvent::class,
//            UpdateItemMessage::class            => UpdateItemEvent::class,
//            PriceIndexChangeMessage::class      => PriceIndexChangeEvent::class,
//            StocksChangedMessage::class         => StocksChangedEvent::class,
//            NewMessageMessage::class            => NewMessageEvent::class,
//            UpdateMessageMessage::class         => UpdateMessageEvent::class,
//            ChatClosedMessage::class            => ChatClosedEvent::class,
    ];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     * @throws WebhookException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->header('x-forwarded-for');
        if (
            App::environment('production')
            && !$this->ipIsAllowed($ip)
        ) {
            throw new WebhookException("IP address ({$ip}) is not allowed", 400);
        }

        try {
            $message = MessageFactory::create($request);
            $request->merge([
                'message_type' => $message->message_type
            ]);
        } catch (MessageFactoryException $e) {
            throw new WebhookException('Request type error', 400, $e);
        }

        $this->dispatchEvent($message);

        return $next($request);
    }


    private function ipIsAllowed(string $ip): bool
    {
        $whitelist = config('ozonseller.webhook.whitelist');
        foreach ($whitelist as $range) {
            if ($this->ipInNetwork($ip, $range)) {
                return true;
            }
        }
        return false;
    }


    /**
     * Check if a given ip is in a network
     * https://gist.github.com/tott/7684443
     *
     * @param  string $ip    IP to check in IPV4 format e.g. 127.0.0.1
     * @param  string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
     * @return boolean true if the ip is in this range / false if not.
     */
    private function ipInNetwork(string $ip, string $range): bool
    {
        if (!str_contains($range, '/')) {
            $range .= '/32';
        }
        list($range, $netmask) = explode('/', $range, 2);
        $range_decimal = ip2long($range);
        $ip_decimal = ip2long($ip);
        $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
        $netmask_decimal = ~ $wildcard_decimal;
        return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
    }


    /**
     * @throws WebhookException
     */
    private function dispatchEvent(Data $message): void
    {
        $class_name = get_class($message);
        if (!key_exists($class_name, $this->events)) {
            throw new WebhookException("Unable to find event for message ({$class_name})");
        }
        event(new $this->events[$class_name]($message));
    }
}
