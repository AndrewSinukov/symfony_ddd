Docker for DDD Symfony
=================

Docker infrastructure for DDD Symfony project.

Installation for local development environment
----------------------------------------------

* Install Docker and Docker-compose
* Set `PHP_ENABLE_XDEBUG` to `1` in `services/*/.env` to enable XDebug in certain container (optional).
* Build images by `docker-compose build`.
* Start the project by `docker-compose up -d`.
* Update schema `docker-compose exec core php app/console doctrine:schema:update --force`
* Run migration `docker-compose exec core php bin/console doctrine:migration:migrate`
* Run fixtures `docker-compose exec core php bin/console doctrine:fixtures:load`
* Run composer install `docker-compose exec core composer install`
* Open the project in a browser from URL `localhost:8081`.

External URLs
-------------

* `http://localhost:8081/` — Index page
* `localhost:3307` — Core database
* `localhost:9005` — XDebug remote port (if enabled in `.env`)

Internal URLs
-------------

* `http://nginx:80/` — Index page
* `db:3306` — Core database
* `<service>:9005` — XDebug remote port (if enabled in `.env`)
