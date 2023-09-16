<?php

/**
 * Webhook connector interface.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types = 1);

namespace deepeloper\TunneledWebhooks\Webhook\Connector;

use deepeloper\TunneledWebhooks\RunnerInterface;

/**
 * Webhook connector interface.
 */
interface ConnectorInterface
{
    public function init(RunnerInterface $runner, array $config): void;

    /**
     * Registers webhooks.
     *
     * @return void
     */
    public function register(): void;

    /**
     * Releases webhooks.
     *
     * @return void
     */
    public function release(): void;
}
