<?php

/**
 * Runner unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks;

use PHPUnit\Framework\TestCase;
use RuntimeException;

class RunnerTest extends TestCase
{
    protected static array $config;
    public static function setUpBeforeClass(): void
    {
        self::$config = require_once __DIR__ . "/data/test.config.php";
    }

    /**
     * @cover deepeloper\TunneledWebhooks\Runner::run()
     * @cover deepeloper\TunneledWebhooks\Service\ServiceAbstract::init()
     * @cover deepeloper\TunneledWebhooks\Service\ServiceAbstract::stop()
     *
     */
    public function testRun(): void
    {
        $runner = new TestRunner();
        $runner->run(self::$config);

        self::assertEquals("stub url", $runner->getServiceURL());

        $runner->sendError("message", __METHOD__, false);
    }

    /**
     * @cover deepeloper\TunneledWebhooks\Runner::run()
     */
    public function testInvalidWebhook(): void
    {
        self::expectException(RuntimeException::class);

        $config = self::$config;
        $config['webhook']['Telegram']['Windbag']['class'] =
            "\\deepeloper\\TunneledWebhooks\\Webhook\\Connector\\InvalidConnector";

        $runner = new TestRunner();
        $runner->run($config);
    }
}
