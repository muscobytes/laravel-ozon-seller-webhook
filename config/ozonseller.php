<?php
return [
    'webhook' => [
        'url' => env('OZON_SELLER_WEBHOOK_URL', '/api/ozon/seller/webhook'),

        /**
         * https://docs.ozon.ru/api/seller/#tag/push_start
         */
        'whitelist' => [
            '195.34.21.0/24',
            '185.73.192.0/22',
            '91.223.93.0/24',
        ],
    ]
];
