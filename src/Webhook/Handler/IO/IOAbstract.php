<?php

/**
 * Webhook handling I/O abstract class.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Webhook\Handler\IO;

/**
 * Webhook handling I/O abstract class.
 *
 * @codeCoverageIgnore
 */
abstract class IOAbstract implements IOInterface
{
    protected array $config;

    public function init(array $config): void
    {
        $this->config = $config;
    }
}
