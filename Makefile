format:
	docker-compose exec laravel-api php ./vendor/bin/pint

lint:
	docker-compose exec laravel-api php -d memory_limit=2G ./vendor/bin/phpstan analyse

test:
	docker-compose exec laravel-api php artisan test -p

doc:
	docker-compose exec laravel-api php artisan scribe:generate --verbose

