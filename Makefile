# Define the Docker Compose commands
up:
	docker-compose up -d --build server
down:
	docker-compose down
migrate:
	docker-compose run --rm artisan migrate
artisan:
	docker-compose run --rm artisan $(filter-out $@,$(MAKECMDGOALS))
composer:
	docker-compose run --rm composer $(filter-out $@,$(MAKECMDGOALS))