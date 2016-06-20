.SILENT:
.PHONY: help

## Colors
COLOR_RESET   = \033[0m
COLOR_INFO    = \033[32m
COLOR_COMMENT = \033[33m

## Help
help:
	printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	printf " make <target>\n\n"
	printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

###########
# Install #
###########

## Install application
install: install-deps install-database

install-deps:
	composer install

install-database:
	php bin/console doctrine:database:create --if-not-exists
	php bin/console doctrine:schema:update --force

##########
# Update #
##########

## Update application
update: update-deps update-database

update-deps:
	composer update

update-database:
	php bin/console doctrine:schema:update --force

########
# Test #
########

## Run tests
test:
	vendor/bin/phpunit

## Run unit tests
test-unit:
	vendor/bin/phpunit --testsuite unit

## Run functionnal tests
test-func:
	vendor/bin/phpunit --testsuite functionnal

## Code coverage
coverage:
	vendor/bin/phpunit --testsuite unit --coverage-text

##########
# Deploy #
##########

## Deploy application
deploy: export SYMFONY_ENV=prod
deploy: deploy-deps deploy-cache

deploy-deps:
	curl -sS https://getcomposer.org/installer | php
	php composer.phar install -o --no-dev

deploy-cache:
	php bin/console cache:clear --env=prod --no-debug