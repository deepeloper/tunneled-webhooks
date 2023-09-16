<?php

/**
 * Tunneling service abstract class.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Service;

use deepeloper\TunneledWebhooks\RunnerInterface;

/**
 * Tunneling service abstract class.
 */
abstract class ServiceAbstract implements ServiceInterface
{
    protected RunnerInterface $runner;

    protected array $config;

    /**
     * Resource of process
     *
     * @var resource|bool
     */
    protected $process;

    public function init(RunnerInterface $runner, array $config): void
    {
        $this->runner = $runner;
        $this->config = $config;
    }

    public function start(): void
    {
        $this->runner->sendMessage("Starting of tunneling service...", __METHOD__);
        $this->createProcess();
        if (false === $this->process) {
            // @codeCoverageIgnoreStart
            $this->runner->sendError("Cannot start tunneling service", __METHOD__);
            // @codeCoverageIgnoreEnd
        }
        sleep($this->config['delay']);
        $status = $this->getProcessStatus();
        if (empty($status['running'])) {
            // @codeCoverageIgnoreStart
            $this->runner->sendError("Starting of tunneling service failed", __METHOD__);
            // @codeCoverageIgnoreEnd
        } else {
            $this->runner->sendMessage("Tunneling service started successfully", __METHOD__);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function stop(?string $reason = null): void
    {
        if (is_resource($this->process)) {
            proc_terminate($this->process);
            proc_close($this->process);
            $message = "Tunneling service stopped";
            if (null !== $reason) {
                $message = sprintf("%s: %s", $message, $reason);
            }
            $this->runner->sendMessage($message, __METHOD__);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    protected function createProcess(): void
    {
        $pipes = [];
        $this->process = proc_open(
            $this->config['command'],
            [],
            $pipes,
            null,
            null,
            ['bypass_shell' => true],
        );
    }

    /**
     * @codeCoverageIgnore
     */
    protected function getProcessStatus(): array|false
    {
        return proc_get_status($this->process);
    }
}
