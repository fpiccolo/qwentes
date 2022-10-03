# Executables (local)
DOCKER_COMP = docker-compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php


init: destroy start sleep-10 initialization

reset: destroy up sleep-10 initialization

initialization: composer-install migrate first-user

destroy:
	@$(DOCKER_COMP) down --remove-orphans -v

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach

start: build up ## Build and start the containers

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) sh

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer-install:
	@$(PHP_CONT) composer install


## —— Doctrine ————————————————————————————————————————————————————————————————
migrate:
	@$(PHP_CONT) vendor/bin/doctrine-migrations --no-interaction migrations:migrate

first-user:
	@$(PHP_CONT) php bin/console.php user:create Luca Rossi l.rossi@gmail.com  Zaq12wsx%$

sleep-%:
	sleep $(@:sleep-%=%)