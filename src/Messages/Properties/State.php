<?php

namespace Muscobytes\OzonSeller\Messages\Properties;

use Spatie\Enum\Laravel\Enum;


/**
 * @method static self posting_acceptance_in_progress()
 * @method static self posting_created()
 * @method static self posting_awaiting_registration()
 * @method static self posting_transferring_to_delivery()
 * @method static self posting_in_carriage()
 * @method static self posting_not_in_carriage()
 * @method static self posting_in_arbitration()
 * @method static self posting_in_client_arbitration()
 * @method static self posting_on_way_to_city()
 * @method static self posting_transferred_to_courier_service()
 * @method static self posting_in_courier_service()
 * @method static self posting_on_way_to_pickup_point()
 * @method static self posting_in_pickup_point()
 * @method static self posting_conditionally_delivered()
 * @method static self posting_driver_pick_up()
 * @method static self posting_delivered()
 * @method static self posting_received()
 * @method static self posting_canceled()
 * @method static self posting_not_in_sort_center()
 */
class State extends Enum
{
}