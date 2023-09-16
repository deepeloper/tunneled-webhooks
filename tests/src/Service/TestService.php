<?php

/**
 * Service for unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Service;

/**
 * Ngrok tunneling service.
 */
class TestService extends Ngrok
{
    public function getURL(): string
    {
        return "stub url";
    }
    protected function createProcess(): void
    {
        $this->process = true;
    }

    protected function getProcessStatus(): array|false
    {
        return [
            'running' => true,
        ];
    }
}
