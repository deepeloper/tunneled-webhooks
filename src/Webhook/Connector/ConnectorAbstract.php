<?php

/**
 * Webhook connector abstract class.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types = 1);

namespace deepeloper\TunneledWebhooks\Webhook\Connector;

use deepeloper\TunneledWebhooks\RunnerInterface;

/**
 * Webhook connector abstract class.
 */
abstract class ConnectorAbstract implements ConnectorInterface
{
    protected RunnerInterface $runner;

    protected array $config;

    public function init(RunnerInterface $runner, array $config): void
    {
        $this->runner = $runner;
        $this->config = $config;
    }
}
