<?php

/**
 * Config file skeleton.
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
        'class' => "\\deepeloper\\TunneledWebhooks\\Service\Ngrok",
        // CLI command to run service.
        // Modify path here:
        'command' => "/path/to/ngrok http 80",
        // Delay after starting service.
        // 3 seconds enough to start service and connect their servers at my place.
        'delay' => 5, // in seconds
        // Default ngrok status page
        'status' => "http://localhost:4040/api/tunnels",
    ],

    'webhook' => [
        'Telegram' => [
            'Windbag' => [
                'class' => "\\deepeloper\\TunneledWebhooks\\Webhook\\Connector\\Telegram",
                'url' => [
                    'register' => "https://api.telegram.org/bot%s/setWebhook?url=%s/org.telegram/bot.windbag.php",
                    'release' => "https://api.telegram.org/bot%s/deleteWebhook",
                ],
                // Telegram bot token.
                // Modify token here:
                'token' => "",
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
