<?php

/**
 * Webhook handling abstract class.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Webhook\Handler;

/**
 * Webhook handling abstract class.
 *
 * @codeCoverageIgnore
 */
abstract class HandlerAbstract implements HandlerInterface
{
    protected IO\IOInterface $io;

    public function init(IO\IOInterface $io): void
    {
        $this->io = $io;
    }
}
