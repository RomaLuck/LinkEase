## Table of contents

* [General info](#general-info)
* [Tools](#tools)
* [Current features](#current-features)
* [Setup](#setup)
* [Test](#test)

## General info

Manager of informational messages

## Tools

- Docker v27.1.2
- PHP v8.2
- Mariadb latest
- Bootstrap v5.3.2
- RabbitMQ v3.*
- BladeOne dev
- Phpunit v.11.0
- Symfony/mailer v7.1

## Current features

- Authorization through social networks
- Async/Queued Messages
- Sender of messages via telegram or email
- Сhat-gpt client for creating an information library

## Setup

Copy the .env.dist file and edit the entries to your needs:

```
cp .env.dist .env
```

Add current user identity data to environments
```sh
echo UID=$(id -u) >> .env
echo GID=$(id -g) >> .env
```

Start docker-compose to start your environment:

```
docker-compose up
```

Create a folder for caching blade and grant permissions
```
docker exec -it linkease-apache-php bash

mkdir var/cache
chown -R www-data:www-data var/cache
```

Install Packages

```
docker exec linkease-apache-php composer install
```

Create schemas

```
docker exec linkease-apache-php bin/doctrine orm:schema-tool:create
```

## Test

Copy the phpunit.xml file and edit the entries to your needs:

```
cp phpunit.xml.dist phpunit.xml
```

Run tests

```
docker exec linkease-apache-php vendor/bin/phpunit
```