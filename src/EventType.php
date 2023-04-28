<?php
namespace Muscobytes\OzonSeller;

use Muscobytes\OzonSeller\Events\NewPostingEvent;
use Muscobytes\OzonSeller\Events\PingEvent;
use Illuminate\Http\Request;
use Muscobytes\OzonSeller\Exceptions\EventTypeException;

/**
 * https://docs.ozon.ru/api/seller/#tag/push_types
 */
final class EventType
{
    private static array $map = [
        'TYPE_PING'                     => PingEvent::class,
        'TYPE_NEW_POSTING'              => NewPostingEvent::class,
//        'TYPE_POSTING_CANCELLED'        => PostingCanceled::class,
//        'TYPE_STATE_CHANGED'            => self::TYPE_STATE_CHANGED,
//        'TYPE_CUTOFF_DATE_CHANGED'      => self::TYPE_CUTOFF_DATE_CHANGED,
//        'TYPE_DELIVERY_DATE_CHANGED'    => self::TYPE_DELIVERY_DATE_CHANGED,
//        'TYPE_CREATE_ITEM'              => self::TYPE_CREATE_ITEM,
//        'TYPE_UPDATE_ITEM'              => self::TYPE_UPDATE_ITEM,
//        'TYPE_PRICE_INDEX_CHANGED'      => self::TYPE_PRICE_INDEX_CHANGED,
//        'TYPE_STOCKS_CHANGED'           => self::TYPE_STOCKS_CHANGED,
//        'TYPE_NEW_MESSAGE'              => self::TYPE_NEW_MESSAGE,
//        'TYPE_UPDATE_MESSAGE'           => self::TYPE_UPDATE_MESSAGE,
//        'TYPE_CHAT_CLOSED'              => self::TYPE_CHAT_CLOSED,
    ];


    /**
     * @throws EventTypeException
     */
    public static function validate(string $type): string
    {
        if (!key_exists($type, self::$map)) {
            throw new EventTypeException("Illegal EventType code: {$type}", 400);
        }
        return $type;
    }


    /**
     * @throws EventTypeException
     */
    public static function getEventClass(string $type)
    {
        self::validate($type);
        return self::$map[$type];
    }


    /**
     * @throws EventTypeException
     */
    public static function fromRequest(Request $request): string
    {
        $body = json_decode($request->getContent(), true);

        if (!is_array($body)) {
            throw new EventTypeException('Request body contents must be a JSON structure');
        }

        if (!key_exists('message_type', $body)) {
            throw new EventTypeException('Property `message_type` is missing');
        }

        return self::validate($body['message_type']);
    }
}
