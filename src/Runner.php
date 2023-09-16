<?php

/**
 * Runner.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks;

use deepeloper\TunneledWebhooks\Service\ServiceInterface;
use deepeloper\TunneledWebhooks\Webhook\Connector\ConnectorInterface;
use JetBrains\PhpStorm\NoReturn;
use RuntimeException;
use Throwable;

/**
 * Runs tunnelling service and registers webhooks.
 */
class Runner implements RunnerInterface
{
    protected array $config;

    protected bool $logSpecifiedSources;

    protected array $levelToString = [
        E_NOTICE => "note",
        E_WARNING => "WARN",
        E_ERROR => "!ERR",
    ];

    /**
     * Tunneling service object
     */
    protected ?ServiceInterface $service = null;

    /**
     * @var ConnectorInterface[]
     */
    protected array $webhooks = [];

    public function run(array $config): void
    {
        $this->config = $config;
        $this->logSpecifiedSources =
            !isset($config['logging']['sources']) || !in_array("*", $config['logging']['sources']);

        if (function_exists("pcntl_signal")) {
            // @codeCoverageIgnoreStart
            pcntl_signal(SIGTERM, [$this, "handleShutdown"]);
            // @codeCoverageIgnoreEnd
        }

        try {
            $this->startService();
            $this->registerWebhooks();
            $this->loop();
            // @codeCoverageIgnoreStart
        } catch (Throwable $e) {
            if (is_object($this->service)) {
                $this->service->stop(sprintf(
                    "%s\n%s",
                    $e->getMessage(),
                    $e->getTraceAsString()
                ));
            }
            throw $e;
            // @codeCoverageIgnoreEnd
        }
    }

    public function getServiceURL(): string
    {
        return $this->service->getURL();
    }

    public function sendMessage(string $message, string $source): void
    {
        $this->log($message, $source);
    }

    #[NoReturn] public function sendError(string $message, string $source, bool $exit = true): void
    {
        $this->service->stop($message);
        $this->log($message, $source, E_ERROR);
        if ($exit) {
            // @codeCoverageIgnoreStart
            exit(1);
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Handles terminate signal.
     *
     * @codeCoverageIgnore
     */
    public function handleShutdown(int $number, mixed $info = null): void
    {
        $indexes = array_keys($this->webhooks);
        foreach ($indexes as $index) {
            $this->webhooks[$index]->release();
            unset($this->webhooks[$index]);
        }
        $this->service->stop("Runner stopped");
        $this->service = null;
    }

    /**
     * Starts tunneling service.
     */
    protected function startService(): void
    {
        $class = $this->config['service']['class'];
        $this->service = new $class();
        $this->service->init($this, $this->config['service']);
        $this->service->start();
    }

    /**
     * Registers webhooks.
     */
    protected function registerWebhooks(): void
    {
        $webhooks = array_keys($this->config['webhook']);
        foreach ($webhooks as $platform) {
            $products = array_keys($this->config['webhook'][$platform]);
            foreach ($products as $product) {
                $config = $this->config['webhook'][$platform][$product];
                $class = $config['class'];
                $this->log("Processing 'webhook/$platform/$product'...", __METHOD__);
                /**
                 * @var ConnectorInterface $instance
                 */
                $instance = new $class();
                if (!($instance instanceof ConnectorInterface)) {
                    throw new RuntimeException(sprintf(
                        "Class %s must implement %s",
                        $class,
                        ConnectorInterface::class
                    ));
                }
                $instance->init($this, $config);
                $instance->register();
                $this->webhooks[] = $instance;
            }
        }
    }

    /**
     * @codeCoverageIgnore
     */
    protected function loop(): void
    {
//            $minutes = 0;
//            while (++$minutes) {
//                sleep(60);
//                $this->sendMessage("Working for $minutes minutes...", __METHOD__);
//            }
        while (true) {
            sleep(3600);
        }
    }

    protected function log(string $message, string $source, int $level = E_NOTICE): void
    {
        if (
            !($this->config['logging']['level'] & $level) ||
            ($this->logSpecifiedSources && !in_array($source, $this->config['logging']['sources']))
        ) {
            // @codeCoverageIgnoreStart
            return;
            // @codeCoverageIgnoreEnd
        }
        file_put_contents(
            $this->config['logging']['target'],
            sprintf(
                "[%s] [%s] [%s] %s\n",
                date("Y-m-d H:i:s"),
                $this->levelToString[$level],
                $source,
                $message,
            ),
        );
    }
}
