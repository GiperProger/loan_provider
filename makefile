PROJECT_NAME = credit-app

DOCKER_COMPOSE = docker-compose

# Основные цели
up:
	$(DOCKER_COMPOSE) up -d --build

down:
	$(DOCKER_COMPOSE) down

restart:
	$(DOCKER_COMPOSE) down
	$(DOCKER_COMPOSE) up -d --build

logs:
	$(DOCKER_COMPOSE) logs -f

install: composer-install db-migrate

composer-install:
	$(DOCKER_COMPOSE) exec php composer install

db-migrate:
	$(DOCKER_COMPOSE) exec php php bin/console doctrine:database:create --if-not-exists
	$(DOCKER_COMPOSE) exec php php bin/console doctrine:migrations:migrate --no-interaction

reset:
	$(DOCKER_COMPOSE) down -v
	$(DOCKER_COMPOSE) up -d --build
	$(MAKE) install

test:
	$(DOCKER_COMPOSE) exec php php bin/phpunit