<?php

namespace Muscobytes\OzonSeller;

use Illuminate\Http\Request;
use Muscobytes\OzonSeller\Exceptions\MessageFactoryException;
use Muscobytes\OzonSeller\Messages\CreateItemMessage;
use Muscobytes\OzonSeller\Messages\CutoffDateChangedMessage;
use Muscobytes\OzonSeller\Messages\DeliveryDateChangedMessage;
use Muscobytes\OzonSeller\Messages\NewPostingMessage;
use Muscobytes\OzonSeller\Messages\PingMessage;
use Muscobytes\OzonSeller\Messages\PostingCancelledMessage;
use Muscobytes\OzonSeller\Messages\StateChangedMessage;
use Spatie\LaravelData\Data;

class MessageFactory
{
    /**
     * https://docs.ozon.ru/api/seller/#tag/push_types
     */
    protected static array $map = [
        'TYPE_PING'                     => PingMessage::class,
        'TYPE_NEW_POSTING'              => NewPostingMessage::class,
        'TYPE_POSTING_CANCELLED'        => PostingCancelledMessage::class,
        'TYPE_STATE_CHANGED'            => StateChangedMessage::class,
        'TYPE_CUTOFF_DATE_CHANGED'      => CutoffDateChangedMessage::class,
        'TYPE_DELIVERY_DATE_CHANGED'    => DeliveryDateChangedMessage::class,
        'TYPE_CREATE_ITEM'              => CreateItemMessage::class,
//        'TYPE_UPDATE_ITEM'              => UpdateItemMessage::class,
//        'TYPE_PRICE_INDEX_CHANGED'      => PriceIndexChangeMessage::class,
//        'TYPE_STOCKS_CHANGED'           => StocksChangedMessage::class,
//        'TYPE_NEW_MESSAGE'              => NewMessageMessage::class,
//        'TYPE_UPDATE_MESSAGE'           => UpdateMessageMessage::class,
//        'TYPE_CHAT_CLOSED'              => ChatClosedMessage::class
    ];


    /**
     * @throws MessageFactoryException
     */
    public static function create(Request $request): Data
    {
        $data = self::fromRequest($request);
        $class_name = self::$map[$data['message_type']];
        // @TODO check instance of $class_name == `Data`
        return $class_name::validateAndCreate($data);
    }


    /**
     * @throws MessageFactoryException
     */
    public static function fromRequest(Request $request): array
    {
        $body = json_decode($request->getContent(), true);

        if (!is_array($body)) {
            throw new MessageFactoryException('Request body contents must be a JSON structure', 400);
        }

        if (!key_exists('message_type', $body)) {
            throw new MessageFactoryException('Property `message_type` is missing', 400);
        }

        if (!key_exists($body['message_type'], self::$map)) {
            throw new MessageFactoryException("Illegal EventType code: {$body['message_type']}", 400);
        }

        return $body;
    }
}