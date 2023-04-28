<?php
return [
    'webhook' => [
        'url' => '/integrations/ozon',

        /**
         * https://docs.ozon.ru/api/seller/#tag/push_start
         */
        'whitelist' => [
            '195.34.21.0/24',
            '185.73.192.0/22',
            '91.223.93.0/24'
        ],
    ]
];
