<?php

/**
 * Webhook handling interface.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Webhook\Handler;

/**
 * Webhook handling interface.
 */
interface HandlerInterface
{
    public function init(IO\IOInterface $io): void;

    /**
     * Processes request to webhook and sends response.
     */
    public function run($options = null): void;
}
