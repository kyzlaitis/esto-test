run:
	composer install
	docker-compose up -d
	sleep 3
	php artisan db:seed --class=UserAdminSeeder
	./vendor/bin/phpunit
down:
	docker-compose down