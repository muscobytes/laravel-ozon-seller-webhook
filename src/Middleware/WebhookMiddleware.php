<?php

namespace Muscobytes\OzonSeller\Middleware;

use Closure;
use Illuminate\Http\Request;
use Muscobytes\OzonSeller\Events\NewPostingEvent;
use Muscobytes\OzonSeller\Events\PingEvent;
use Muscobytes\OzonSeller\Events\PostingCancelledEvent;
use Muscobytes\OzonSeller\Events\StateChangedEvent;
use Muscobytes\OzonSeller\Exceptions\MessageFactoryException;
use Muscobytes\OzonSeller\Exceptions\WebhookException;
use Muscobytes\OzonSeller\MessageFactory;
use Muscobytes\OzonSeller\Messages\NewPostingMessage;
use Muscobytes\OzonSeller\Messages\PingMessage;
use Muscobytes\OzonSeller\Messages\StateChangedMessage;
use Spatie\LaravelData\Data;
use Symfony\Component\HttpFoundation\Response;
use Muscobytes\OzonSeller\Messages\PostingCancelledMessage;


class WebhookMiddleware
{
    private array $events = [
        PingMessage::class                  => PingEvent::class,
        NewPostingMessage::class            => NewPostingEvent::class,
        PostingCancelledMessage::class      => PostingCancelledEvent::class,
        StateChangedMessage::class          => StateChangedEvent::class,
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
        try {
            $message = MessageFactory::create($request);
            $request->merge([
                'message_type' => $message->message_type
            ]);
        } catch (MessageFactoryException $e) {
            throw new WebhookException('Message type error', 400, $e);
        }

        $this->dispatchEvent($message);

        return $next($request);
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
