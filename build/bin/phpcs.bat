@echo ------------------------------------------------------
@cd "../.."
@call php "vendor/bin/phpcs" --standard=PSR12 src tests config.skeleton.php bot.windbag tunneled-webhooks
