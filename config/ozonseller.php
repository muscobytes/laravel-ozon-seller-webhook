<?php
return [
    'webhook' => [
        'url' => env('OZON_SELLER_WEBHOOK_URL', '/api/ozon/seller/webhook/{client_id}'),
    ],
];
