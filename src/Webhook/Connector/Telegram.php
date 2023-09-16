<?php

/**
 * Telegram webhook connector.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types = 1);

namespace deepeloper\TunneledWebhooks\Webhook\Connector;

/**
 * Telegram webhook connector.
 */
class Telegram extends ConnectorAbstract
{
    public function register(): void
    {
        $this->runner->sendMessage("Requesting Telegram API to register webhook...", __METHOD__);

        $fail = null;
        do {
            $url = sprintf(
                $this->config['url']['register'],
                $this->config['token'],
                $this->runner->getServiceURL(),
            );
            $response = file_get_contents($url);
            file_put_contents(
                "d:/tg.log",
                "url: $url, response: $response\n",
                FILE_APPEND
            );###
            if (false === $response) {
                $fail = "Requesting Telegram API failed";
                break;
            }
            $decoded = json_decode($response, true);
            if (null === $decoded) {
                $fail = "Invalid response from Telegram API";
                break;
            }
            if (empty($decoded['ok']) || empty($decoded['result'])) {
                $fail = "Telegram API: registering of webhook failed";
                break;
            }
            $this->runner->sendMessage("Telegram webhook set successfully", __METHOD__);
        } while (false);

        if (null !== $fail) {
            $this->runner->sendError($fail, __METHOD__);
        }
    }

    public function release(): void
    {
        $this->runner->sendMessage("Requesting Telegram API to release webhook...", __METHOD__);

        $fail = null;
        do {
            $url = sprintf(
                $this->config['url']['release'],
                $this->config['token'],
            );
            $response = file_get_contents($url);
            if (false === $response) {
                $fail = "Requesting Telegram API failed";
                break;
            }
            $decoded = json_decode($response, true);
            if (null === $decoded) {
                $fail = "Invalid response from Telegram API";
                break;
            }
            if (empty($decoded['ok']) || empty($decoded['result'])) {
                $fail = "Telegram API: releasing of webhook failed";
                break;
            }
            $this->runner->sendMessage(
                sprintf("Telegram response: %s", $decoded['description']),
                __METHOD__,
            );
        } while (false);

        if (null !== $fail) {
            $this->runner->sendError($fail, __METHOD__);
        }
    }
}
