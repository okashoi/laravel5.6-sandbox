PHP = docker-compose exec php-cli
NODE = docker-compose run --rm node

.PHONY: init/* setup up down artisan composer node npm

.env:
	cp .env.example .env

src/.env:
	cp src/.env.example src/.env

setup: .env src/.env
	$(MAKE) init/permission
	$(MAKE) up
	$(MAKE) composer CMD="install"
	$(MAKE) artisan CMD="key:generate"
	$(MAKE) artisan CMD="migrate"
	$(MAKE) npm CMD="install"
	$(MAKE) npm CMD="run dev"

init/permission:
	chmod -R 777 src/storage src/bootstrap/cache

up: .env
	docker-compose up -d --force-recreate --build

down:
	docker-compose down

artisan: src/.env
	$(PHP) php artisan $(CMD)

composer:
	$(PHP) composer $(CMD)

node:
	$(NODE) node $(CMD)

npm:
	$(NODE) npm $(CMD)
