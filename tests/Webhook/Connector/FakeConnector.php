<?php

/**
 * Webhook connector for unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace Tests\Webhook\Connector;

use deepeloper\TunneledWebhooks\Webhook\Connector\Telegram;

class FakeConnector extends Telegram
{
    public function register(): void
    {
    }

    public function release(): void
    {
    }
}
