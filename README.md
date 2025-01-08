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
    docker-compose up -d --build server
    ```

4. Create the database
    ```sh
    docker compose run artisan migrate
    ```

### Makerfile Commands

1. Restart the server container and its dependencies:
    ```sh
    make up
    ```

2. To stop the containers:
    ```sh
    make down
    ```

3. To execute a composer command:
    ```sh
    make composer <command>
    ```

4. To execute a Laravel artisan command:
    ```sh
    make artisan <command>

    # For example:
    make artisan make:controller JobController
    ```

5. Run database migration:
    ```sh
    make composer migrate
    ```

### Additional Commands

- To rebuild the server without using the cache:
    ```sh
    docker-compose build server --no-cache
    ```

- To remove all stopped containers, networks, and volumes:
    ```sh
    docker-compose down -v
    ```

## Contributing

Please read CONTRIBUTING.md for details on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the LICENSE file for details.