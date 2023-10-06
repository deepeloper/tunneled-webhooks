<?php

/**
 * Test runner for unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace Tests;

use deepeloper\TunneledWebhooks\Runner;

/**
 * Runs tunnelling service and registers webhooks.
 */
class FakeRunner extends Runner
{
    protected function loop(): void
    {
    }
}
