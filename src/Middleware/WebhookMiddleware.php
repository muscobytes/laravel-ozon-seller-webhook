<?php

namespace Muscobytes\OzonSeller\Middleware;

use Closure;
use Illuminate\Http\Request;
use Muscobytes\OzonSeller\Events\CreateItemEvent;
use Muscobytes\OzonSeller\Events\CutoffDateChangedEvent;
use Muscobytes\OzonSeller\Events\DeliveryDateChangedEvent;
use Muscobytes\OzonSeller\Events\MessageReadEvent;
use Muscobytes\OzonSeller\Events\NewMessageEvent;
use Muscobytes\OzonSeller\Events\NewPostingEvent;
use Muscobytes\OzonSeller\Events\PingEvent;
use Muscobytes\OzonSeller\Events\PostingCancelledEvent;
use Muscobytes\OzonSeller\Events\PriceIndexChangedEvent;
use Muscobytes\OzonSeller\Events\StateChangedEvent;
use Muscobytes\OzonSeller\Events\StocksChangedEvent;
use Muscobytes\OzonSeller\Events\UpdateItemEvent;
use Muscobytes\OzonSeller\Events\UpdateMessageEvent;
use Muscobytes\OzonSeller\Exceptions\MessageFactoryException;
use Muscobytes\OzonSeller\Exceptions\WebhookException;
use Muscobytes\OzonSeller\MessageFactory;
use Muscobytes\OzonSeller\Messages\CreateItemMessage;
use Muscobytes\OzonSeller\Messages\CutoffDateChangedMessage;
use Muscobytes\OzonSeller\Messages\DeliveryDateChangedMessage;
use Muscobytes\OzonSeller\Messages\MessageReadMessage;
use Muscobytes\OzonSeller\Messages\NewMessageMessage;
use Muscobytes\OzonSeller\Messages\NewPostingMessage;
use Muscobytes\OzonSeller\Messages\PingMessage;
use Muscobytes\OzonSeller\Messages\PostingCancelledMessage;
use Muscobytes\OzonSeller\Messages\PriceIndexChangedMessage;
use Muscobytes\OzonSeller\Messages\StateChangedMessage;
use Muscobytes\OzonSeller\Messages\StocksChangedMessage;
use Muscobytes\OzonSeller\Messages\UpdateItemMessage;
use Muscobytes\OzonSeller\Messages\UpdateMessageMessage;
use Spatie\LaravelData\Data;
use Symfony\Component\HttpFoundation\Response;


class WebhookMiddleware
{
    private array $events = [
        PingMessage::class                  => PingEvent::class,
        NewPostingMessage::class            => NewPostingEvent::class,
        PostingCancelledMessage::class      => PostingCancelledEvent::class,
        StateChangedMessage::class          => StateChangedEvent::class,
        CutoffDateChangedMessage::class     => CutoffDateChangedEvent::class,
        DeliveryDateChangedMessage::class   => DeliveryDateChangedEvent::class,
        CreateItemMessage::class            => CreateItemEvent::class,
        UpdateItemMessage::class            => UpdateItemEvent::class,
        PriceIndexChangedMessage::class     => PriceIndexChangedEvent::class,
        StocksChangedMessage::class         => StocksChangedEvent::class,
        NewMessageMessage::class            => NewMessageEvent::class,
        UpdateMessageMessage::class         => UpdateMessageEvent::class,
        MessageReadMessage::class           => MessageReadEvent::class,
//        ChatClosedMessage::class            => ChatClosedEvent::class,
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
