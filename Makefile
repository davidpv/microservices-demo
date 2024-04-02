#!/bin/bash
.PHONY: init build up composer down restart fixtures ssh-users ssh-blog consumers

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

init: ## Initialize the environment
	@make down
	@make build
	@make up
	@make composer
	@make setup-transports
	@make fixtures

build: ## Build the container
	@docker compose build

up: ## Start the container
	@docker compose up -d

composer: ## Install composer dependencies
	@docker compose exec users composer install
	@docker compose exec blog composer install

restart: ## Restart the container
	@docker compose restart

down: ## Stop the container
	@docker compose down

fixtures: ## Load fixtures
	@docker compose exec users php bin/console doctrine:schema:update --force --complete --em=default
	@docker compose exec blog php bin/console doctrine:schema:update --force --complete --em=default
	@docker compose exec users php bin/console doctrine:schema:update --force --complete --em=events
	@docker compose exec users php bin/console doctrine:fixtures:load --no-interaction --env=null
	@docker compose exec blog php bin/console doctrine:fixtures:load --no-interaction --env=null

ssh-users: ## SSH into the users container
	@docker compose exec users bash

ssh-blog: ## SSH into the blog container
	@docker compose exec blog bash

setup-transports: ## Setup transports
	@docker compose exec users php bin/console messenger:setup-transports

## docker compose exec -T users php bin/console messenger:consume async -vv
## docker compose exec -T blog php bin/console messenger:consume async
## docker compose exec -T blog php bin/console messenger:consume async_priority_high -vv

