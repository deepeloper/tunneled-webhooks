<?php

/**
 * Runner interface.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types = 1);

namespace deepeloper\TunneledWebhooks;

interface RunnerInterface
{
    public function run(array $config): void;

    /**
     * Returns tunneling service URL.
     *
     * @return string
     */
    public function getServiceURL(): string;

    /**
     * Sends message.
     */
    public function sendMessage(string $message, string $source): void;

    /**
     * Stops service, sends error and exits.
     */
    public function sendError(string $message, string $source): void;
}
