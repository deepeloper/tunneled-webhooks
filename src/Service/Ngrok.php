<?php

/**
 * ngrok tunneling service.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Service;

/**
 * Ngrok tunneling service.
 */
class Ngrok extends ServiceAbstract
{
    protected ?string $url = null;

    /**
     * @codeCoverageIgnore
     */
    public function getURL(): string
    {
        if (null === $this->url) {
            $this->runner->sendMessage("Requesting ngrok service tunnels...", __METHOD__);
            $response = file_get_contents($this->config['status']);
            $decoded = json_decode($response, true);
            if (null === $decoded) {
                $this->runner->sendError(
                    "Cannot parse Ngrok service tunnels response: $response",
                    __METHOD__,
                );
            }
            if (!isset($decoded['tunnels'])) {
                $this->runner->sendError(
                    sprintf(
                        "Invalid Ngrok service tunnels response: %s",
                        var_export($decoded, true),
                    ),
                    __METHOD__,
                );
            }
            if (!isset($decoded['tunnels'][0]) || !isset($decoded['tunnels'][0]['public_url'])) {
                $this->runner->sendError(
                    sprintf(
                        "Empty Ngrok service tunnels response:\n%s",
                        var_export($decoded, true),
                    ),
                    __METHOD__,
                );
            }
            $this->runner->sendMessage("ngrok service tunnels received", __METHOD__);
            $this->url = $decoded['tunnels'][0]['public_url'];
        }

        return $this->url;
    }

    public function stop(?string $reason = null): void
    {
        $this->url = null;

        parent::stop($reason);
    }
}
