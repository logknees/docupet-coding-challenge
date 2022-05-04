server:
	cd laravel && docker-compose up

client: 
	cd vue-app && docker-compose up

serve:
	xdg-open http://localhost:8081
