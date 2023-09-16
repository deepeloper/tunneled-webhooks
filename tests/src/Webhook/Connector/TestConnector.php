<?php

/**
 * Webhook connector for unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Webhook\Connector;

class TestConnector extends Telegram
{
    public function register(): void
    {
    }

    public function release(): void
    {
    }
}
