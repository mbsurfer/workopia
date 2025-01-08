# Workopia (Laravel)

The goal of this project is to demonstrate a strong understanding of Laravel's core features following a Udemy course by Brad Traversy. Local development is configured using Docker in order to simplify the setup process.

## Getting Started

These instructions will help you set up and run the project using Docker.

### Prerequisites

- Docker
- Docker Compose

### Installation

1. Clone the repository:
    ```sh
    git clone <repository-url>
    cd <repository-directory>
    ```

2. Copy the example environment variables file and modify it as needed:
    ```sh
    cp src/.env.example src/.env
    ```

3. Build and start the server container and its dependencies:
    ```sh
    make start
    
    # OR

    docker-compose up -d --build server
    ```

4. Install dependencies
    ```sh
    make install
    
    # OR

    docker-compose run --rm composer install

4. Create the database
    ```sh
    make migrate
    
    # OR

    docker-compose run artisan migrate
    ```

## Commands

#### Restart the server container and its dependencies:
```sh
make start
```

#### Stop the containers:
```sh
make stop
```

#### Execute a Composer command:
```sh
make composer <command>
```

#### Execute a Laravel Artisan command:
```sh
make artisan <command>

# For example:
make artisan make:controller JobController
```

#### Run database migration:
```sh
make migrate
```

### Additional Commands

#### Rebuild the server without using the cache:
```sh
docker-compose build server --no-cache
```

#### To remove all stopped containers, networks, and volumes:
```sh
docker-compose down -v
```

## License

This project is licensed under the MIT License - see the LICENSE file for details.