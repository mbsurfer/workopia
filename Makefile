# Define the Docker Compose commands
start:
	docker-compose up -d --build server
stop:
	docker-compose down
install:
	docker-compose run --rm composer install
migrate:
	docker-compose run --rm artisan migrate
artisan:
	docker-compose run --rm artisan $(filter-out $@,$(MAKECMDGOALS))
composer:
	docker-compose run --rm composer $(filter-out $@,$(MAKECMDGOALS))