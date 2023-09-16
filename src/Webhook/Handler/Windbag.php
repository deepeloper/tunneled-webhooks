<?php

/**
 * Windbag bot implementation.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types = 1);

namespace deepeloper\TunneledWebhooks\Webhook\Handler;

/**
 * Windbag bot implementation.
 */
class Windbag extends HandlerAbstract
{
    /**
     * @param string $options  Path to file containing previous incoming phrases
     */
    public function run(mixed $options = null): void
    {
        // Receive message.
        $message = $this->io->receive();
        if (null === $message) {
            return;
        }

        mt_srand();
        $messages = file_exists($options) ? file($options) : [];
        $count = sizeof($messages);
        if ($count > 0) {
            $index = mt_rand(0, $count - 1);
            $reply = trim($messages[$index]);
        } else {
            $reply = ":)";
        }

        // Send reply.
        $this->io->send($reply);

        $messages[] = $message . PHP_EOL;
        file_put_contents($options, implode("", $messages));
    }
}
