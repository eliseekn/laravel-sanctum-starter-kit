test:
	php artisan test -p

analyse:
	./vendor/bin/phpstan analyse --memory-limit=2G\

pint:
	./vendor/bin/pint

documentation:
	php artisan scribe:generate