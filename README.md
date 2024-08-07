# Tunneled Webhooks
[![Packagist version](https://img.shields.io/packagist/v/deepeloper/tunneled-webhooks)](https://packagist.org/packages/deepeloper/tunneled-webhooks)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/deepeloper/tunneled-webhooks.svg)](http://php.net/)
[![GitHub license](https://img.shields.io/github/license/deepeloper/tunneled-webhooks.svg)](https://github.com/deepeloper/tunneled-webhooks/blob/main/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues-raw/deepeloper/tunneled-webhooks.svg)](https://github.com/deepeloper/tunneled-webhooks/issues)
[![Packagist](https://img.shields.io/packagist/dt/deepeloper/tunneled-webhooks.svg)](https://packagist.org/packages/deepeloper/tunneled-webhooks)
[![CI](https://github.com/deepeloper/tunneled-webhooks/actions/workflows/ci.yml/badge.svg?event=push)](https://github.com/deepeloper/tunneled-webhooks/actions)
[![codecov](https://codecov.io/gh/deepeloper/tunneled-webhooks/branch/main/graph/badge.svg)](https://codecov.io/gh/deepeloper/tunneled-webhooks)
<!--
[![Type Coverage](https://shepherd.dev/github/deepeloper/tunneled-webhooks/coverage.svg)](https://shepherd.dev/github/deepeloper/tunneled-webhooks)
-->

[![Donation](https://img.shields.io/badge/Donation-Visa,%20MasterCard,%20Maestro,%20UnionPay,%20YooMoney,%20МИР-red)](https://yoomoney.ru/to/41001351141494)

Runs tunneling service and registers temporary webhooks for workstation having no white IP by one command `/path/to/php bin/run.php /path/to/config.php`.

* Implemented tunneling services: [ngrok](https://ngrok.com/);
* Implemented webhooks connectors: [Telegram](https://core.telegram.org/bots/api#setwebhook);
* Implemented bots: [Windbag](https://github.com/deepeloper/tunneled-webhooks/blob/main/src/Webhook/Handler/Windbag.php).

You can add your own tunneling services, register and handle your own webhooks.

## Compatibility
[![PHP 8.0](https://img.shields.io/badge/PHP->=8.0-%237A86B8)]()

## Installation
`composer require deepeloper/tunneled-webhooks`

### Tunneling services
[Download ngrok](https://ngrok.com/download) (and/or other tunneling services), sign up in service, get auth token and run service once `/path/to/ngrok authtoken %YOUR_NGROCK_AUTH_TOKEN%`.

### Webhooks
[Register Telegram bot](https://core.telegram.org/bots) and receive bot auth token.

### Configuring local web server

* nginx

Add *.ngrok.io subdomains:
```
server {
    listen   127.0.0.1:80;
    server_name ~^(.*)\.ngrok\.io;

    ; This application www-directory
    root /path/to/www;
}
```
and restart nginx.

* Apache

According to [ngrok docs](https://ngrok.com/docs/using-ngrok-with/virtualHosts/) in own config modify
&laquo;service/command&raquo; value as `/path/to/ngrok http --host-header=%LOCAL_HOST_NAME% 80`.

### Application config
Copy &laquo;config.skeleton.php&raquo; to your own config file and put ngrok path & Telegram token to the new file:
```php
    // ...
    'service' => [
        'class' => "\\deepeloper\\TunneledWebhooks\\Service\Ngrok",
        // CLI command to run service.
        // Modify path here:
        'command' => "/path/to/ngrok http 80",
        // ...
    ],
    
    'webhook' => [
        'Telegram' => [
            'Windbag' => [
                // ...
                // Telegram bot token.
                // Modify token here:
                'token' => "",
                // ...
```

## Usage

### Run tunneling service and bot
`vendor/bin/tunneled-webhooks /path/to/config.php`

Tunneling service will be started, Telegram webhook will be registered, and you could to start conversation with Telegram bot.

### Run bot from CLI

`vendor/bin/bot.windbag`
