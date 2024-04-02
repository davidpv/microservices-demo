#!/bin/bash
.PHONY: init build up composer down restart fixtures ssh

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
	@make fixtures

build: ## Build the container
	docker compose build

up: ## Start the container
	docker compose up -d

composer: ## Install composer dependencies
	docker compose exec users composer install

restart: ## Restart the container
	docker compose restart

down: ## Stop the container
	docker compose down

fixtures: ## Load fixtures
	docker compose exec users php bin/console doctrine:schema:update --force --complete
	docker compose exec users php bin/console doctrine:fixtures:load --no-interaction

ssh: ## SSH into the container
	docker compose exec users bash
