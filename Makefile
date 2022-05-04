server-build:
	cd laravel-app && docker-compose build

client-build: 
	cd vue-app && docker-compose build

server:
	cd laravel-app && docker-compose up

client: 
	cd vue-app && docker-compose up

down:
	cd vue-app && docker-compose down && cd .. && cd laravel-app && docker-compose down

serve:
	xdg-open http://localhost:8081
