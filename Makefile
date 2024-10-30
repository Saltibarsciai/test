ENV_FILE := .env
ENV_DIST_FILE := .env.example

copy-env:
	@if [ ! -f $(ENV_FILE) ]; then cp $(ENV_DIST_FILE) $(ENV_FILE); fi

composer-install:
	docker compose run --rm app composer install

key-generate:
	docker compose run --rm app php artisan key:generate

cache-clear:
	docker compose run --rm app php artisan config:clear

migrate:
	docker compose run --rm app php artisan migrate

permissions:
	docker compose run --rm app bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache"

bash:
	docker compose exec app /bin/bash

up:
	docker compose up -d

down:
	docker compose down

setup: copy-env up permissions composer-install key-generate migrate cache-clear queue
	@echo "Setup complete. Application is running at http://localhost:8000"

reset:
	docker compose down -v --remove-orphans

queue:
	docker compose exec app /bin/bash -c "php artisan queue:work --queue=scraping_queue"

