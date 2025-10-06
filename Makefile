config: config-env config-db storage-link

format:
	@php ./vendor/bin/pint

lint:
	@php -d memory_limit=2G ./vendor/bin/phpstan analyse

serve:
	@php artisan serve

test:
	@php artisan test -p

generate-doc:
	@php artisan scribe:generate

config-db:
	@php artisan migrate:fresh --seed

config-env:
	cp .env.example .env
	@php artisan key:generate

storage-link:
	@php artisan storage:link
