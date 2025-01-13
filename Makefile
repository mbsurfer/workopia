# Define the Docker Compose commands
start:
	docker-compose up -d --build server
stop:
	docker-compose down
install:
	docker-compose run --rm composer install
	docker-compose run --rm npm i
migrate:
	docker-compose run --rm artisan migrate
controller:
	docker-compose run --rm artisan make:controller
resource-controller:
	docker-compose run --rm artisan make:controller ${NAME}Controller --resource
component:
	docker-compose run --rm artisan make:component ${NAME}
artisan:
	docker-compose run --rm artisan $(CMD) $(ARGS)
composer:
	docker-compose run --rm composer $(CMD) $(ARGS)
npm:
	docker-compose run --rm npm $(CMD) $(ARGS)
npx:
	docker-compose run --rm npx $(CMD) $(ARGS)
tinker:
	docker-compose run --rm artisan tinker
seeder:
	docker-compose run --rm artisan make:seeder
seed:
	docker-compose run --rm artisan db:seed
dev:
	cd ./src && npm run dev