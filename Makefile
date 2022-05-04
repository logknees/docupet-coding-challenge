server-build:
	cd laravel-app && docker-compose build

client-build: 
	cd vue-app && docker-compose build

server:
	cd laravel-app && docker-compose up

server-setup:
	docker exec app composer install && docker exec app php artisan key:generate && docker exec app php artisan config:cache

client: 
	cd vue-app && docker-compose up

down:
	cd vue-app && docker-compose down && cd .. && cd laravel-app && docker-compose down

serve:
	xdg-open http://localhost:8081
