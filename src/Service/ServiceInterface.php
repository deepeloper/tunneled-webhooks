<?php

/**
 * Tunneling service interface.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types = 1);

namespace deepeloper\TunneledWebhooks\Service;

use deepeloper\TunneledWebhooks\RunnerInterface;

/**
 * Tunneling service interface.
 *
 */
interface ServiceInterface
{
    public function init(RunnerInterface $runner, array $config): void;

    public function start(): void;

    public function stop(?string $reason = null): void;

    /**
     * Returns service URL.
     */
    public function getURL(): string;
}
