<?php

/**
 * Webhook handling I/O interface.
 *
 * Allows to receive/send messages from/to service calling webhook.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Webhook\Handler\IO;

/**
 * Webhook handling I/O interface.
 */
interface IOInterface
{
    public function init(array $config): void;

    /**
     * Returns request from service called webhook.
     */
    public function receive(mixed $args = null): mixed;

    /**
     * Sends response to service called webhook.
     */
    public function send(string $response, mixed $options = null): void;
}
