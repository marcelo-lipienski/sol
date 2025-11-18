# Huggy

## Decisions / trade-offs

There were several conscious design decisions taken in order to keep development simpler.

- no authentication was added
- a few bad design decisions as shortcut
- missing filter/pagination

## Setup / Running

To install/run the application, it needs to have any modern PHP version (>= 8.3), git, composer, and docker installed locally. All other dependencies are handled by the docker setup.

Clone the repository

```sh
git clone git@github.com:marcelo-lipienski/sol
```

Move into project's root directory

```sh
cd sol
```

Copy .env.example into .env
```sh
cp .env.example .env
```

Install depencencies

```sh
composer install
```

Boot the application using docker

```sh
./vendor/bin/sail up -d
```

Run migrations

```sh
./vendor/bin/sail artisan migrate
```

Seed database

```sh
./vendor/bin/sail artisan db:seed
```

Run tests

```sh
./vendor/bin/phpunit tests
```

Access API docs
```
http://localhost/docs/api
```