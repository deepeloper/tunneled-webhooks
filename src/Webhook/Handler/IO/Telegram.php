<?php

/**
 * Telegram webhook handling I/O class.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Webhook\Handler\IO;

use Telegram\Bot\Api;

/**
 * Telegram webhook handling I/O class.
 *
 * Allows to receive/send messages from/to Telegram service calling webhook.
 * Instance created in Telegram windbag bot.
 *
 * @codeCoverageIgnore
 */
class Telegram extends IOAbstract
{
    protected Api $api;

    protected ?int $chatId;

    public function init(array $config): void
    {
        parent::init($config);

        $this->api = new Api($config['token']);
    }

    public function receive(mixed $args = null): mixed
    {
        $update = $this->api->getWebhookUpdate();
        $result = null;
        if (isset($update->message)) {
            $this->chatId = $update->message->chat->id;
            $result = $update->message->text;
        }
        return $result;
    }

    public function send(string $response, mixed $options = null): void
    {
        $message = [
            'chat_id' => $this->chatId,
            'text' => $response,
        ];
        if (null !== $options) {
            $message += $options;
        }
        $this->api->sendMessage($message);
    }
}
