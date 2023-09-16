<?php

/**
 * Console webhook handling I/O class.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types = 1);

namespace deepeloper\TunneledWebhooks\Webhook\Handler\IO;

/**
 * Console "webhook" handling I/O class.
 *
 * Allows to receive from STDIN / send to output messages.<br />
 * Instance created in Console windbag bot.
 */
class Console extends IOAbstract
{
    public function receive($args = null): ?string
    {
        echo $this->config['prompt'], "> ";
        $in = fgets(STDIN);
        return false !== $in ? trim($in) : null;
    }

    public function send(string $response, mixed $options = null): void
    {
        echo $response, PHP_EOL;
    }
}
