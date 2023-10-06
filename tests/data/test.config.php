<?php

/**
 * Config file for unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

return [
    'logging' => [
        'target' => "php://stdout",
        'sources' => ["*"],
        'level' => E_ALL,
    ],

    'service' => [
        'class' => "\\Tests\\Service\FakeService",
//        'class' => "\\deepeloper\\TunneledWebhooks\\Service\Ngrok",
        // Delay after starting service.
        'delay' => 0, // in seconds
    ],

    'webhook' => [
        'Telegram' => [
            'Windbag' => [
                'class' => "\\Tests\\Webhook\\Connector\\FakeConnector",
//                'class' => "\\deepeloper\\TunneledWebhooks\\Webhook\\Connector\\Telegram",
            ],
        ],
    ],

    'CLI' => [
        'Console' => [
            'Windbag' => [
                'prompt' => "windbag> ",
            ],
        ],
    ],
];
