<?php

/**
 * Console windbag bot.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types = 1);

namespace deepeloper\TunneledWebhooks\Webhook\Handler;

error_reporting(E_ALL);
require_once "../vendor/autoload.php";

$config = (require_once "../config/current.php")['CLI']['Console']['Windbag'];
$io = new IO\Console();
$io->init($config);
$bot = new Windbag();
$bot->init($io);

/**
 * Path to "dictionary" file
 */
$path = sprintf("./%s.txt", basename(__FILE__, ".php"));

while (true) {
    $bot->run($path);
}
