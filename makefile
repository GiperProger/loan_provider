PROJECT_NAME = credit-app

DOCKER_COMPOSE = docker-compose

up:
	$(DOCKER_COMPOSE) up -d --build

down:
	$(DOCKER_COMPOSE) down

install: composer-install db-migrate

start: up install

composer-install:
	$(DOCKER_COMPOSE) exec php composer install

db-migrate:
	$(DOCKER_COMPOSE) exec php php bin/console doctrine:database:create --if-not-exists
	$(DOCKER_COMPOSE) exec php php bin/console doctrine:migrations:migrate --no-interaction

test:
	$(DOCKER_COMPOSE) exec php php bin/phpunit

db-migrate-test:
	$(DOCKER_COMPOSE) exec php php bin/console doctrine:database:create --if-not-exists --env=test
	$(DOCKER_COMPOSE) exec php php bin/console doctrine:migrations:migrate --no-interaction --env=test

send-notifications:
	$(DOCKER_COMPOSE) exec php php bin/console app:send-notifications

static-analyse:
	$(DOCKER_COMPOSE) exec php vendor/bin/phpstan analyse