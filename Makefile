.SILENT:

CONFIG_DIR=api/config
DC=docker-compose
DC_UP=$(DC) up -d
DC_EXEC=$(DC) exec php
BIN_CONSOLE=$(DC_EXEC) bin/console

TRAEFIK_LOG=traefik/errors.log
TO_600=chmod 600

network: ## Create external network
	docker network create proxy

install: ## Install project
	docker-compose pull
	docker-compose up --build -d

start: ## Start project
	# Running in detached mode.
	docker-compose up -d --remove-orphans --no-recreate

stop: ## Stop project
	docker-compose stop

logs: ## Show logs
	# Follow the logs.
	docker-compose logs -f

reset-traefik: ## Reset traefik logs
	$(DC) down --remove-orphans
	rm $(TRAEFIK_LOG)
	touch $(TRAEFIK_LOG)
	$(TO_600) traefik/acme.json

traefik-logs: ## Show traefik logs
	docker logs -f traefik

reset: ## Reset all installation (use it with precaution!)
	# Kill containers.
	docker-compose kill
	# Remove containers.
	docker-compose down --volumes --remove-orphans
	# Make a fresh install.
	make install

cache: ## Clear cache
	$(BIN_CONSOLE) cache:clear

back-ssh: ## Connect to the container in ssh
	docker exec -it php sh

composer-install: ## Install composer packages
	$(DC_EXEC) composer install

composer-update: ## Update composer
	$(DC_EXEC) composer update

create-db: ## Create database
	$(BIN_CONSOLE) doctrine:database:create

deploy: up-prod build update install cache up ## Deploy command

drop-db: ## Drop database
	$(DC_UP)
	$(BIN_CONSOLE) doctrine:database:drop --force

reset-db: drop-db create-db migration-migrate ## Reset database

migration-down: ## Remove migration
	$(BIN_CONSOLE) doctrine:migrations:execute --down $(migration)

migration-diff: ## Make the diff
	$(BIN_CONSOLE) doctrine:migrations:diff

migration-generate: ## Create new migration
	$(BIN_CONSOLE) doctrine:migrations:generate

migration-migrate: ## Execute unlisted migrations
	$(BIN_CONSOLE) doctrine:migrations:migrate

up-dev: ## Start containers dev
	cp .env.dev .env
	cp docker-compose.yml.dev docker-compose.yml
	$(MAKE) up

up-prod: ## Start containers prod
	cp .env.prod .env
	cp docker-compose.yml.prod docker-compose.yml
	$(MAKE) up

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help