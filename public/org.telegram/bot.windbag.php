<?php

/**
 * Telegram windbag bot.
 */

declare(strict_types=1);

namespace deepeloper\TunneledWebhooks\Webhook\Handler;

error_reporting(E_ALL);
require_once "../../vendor/autoload.php";

$config = (require_once "../../config.skeleton.php")['webhook']['Telegram']['Windbag'];
$io = new IO\Telegram();
$io->init($config);
$bot = new Windbag();
$bot->init($io);

/**
 * Path to "dictionary" file
 */
$path = sprintf("./%s.txt", basename(__FILE__, ".php"));
$bot->run($path);
