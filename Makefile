.DEFAULT_GOAL := help
.PHONY: $(filter-out vendor, $(MAKECMDGOALS))

help: ## Show this help message
	@printf "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(firstword $(MAKEFILE_LIST)) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

lock: vendor
	@composer update --lock

stan: vendor ## Analyze the source code and manifest document(s)
	@composer validate
	@composer normalize --dry-run
	@vendor/bin/phpcs fix --config=.php_cs --show-progress=dots --ansi -vvv --dry-run
	@vendor/bin/phpinsights --no-interaction \
		--min-quality=70 \
		--min-complexity=90 \
		--min-architecture=70 \
		--min-style=90

style: vendor ## Format the source code and other documents in the repository
	@composer normalize
	@vendor/bin/php-cs-fixer --show-progress=dots --ansi -vvv

test: vendor ## Run tests
	@vendor/bin/pest --configuration=phpunit.xml --color=always

vendor: composer.json ## Install third-party dependencies
	@composer install --optimize-autoloader
	@touch vendor/
