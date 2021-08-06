# P7 OC DA/PHP - Symfony

Create a web service exposing an API

## Getting Started

These instructions will get you a copy of the project up and running on your local machine if you want to test it or develop something on it.

## Prerequisites

To make the project run you will need to install those things :

* [Laragon](https://laragon.org/download/)
* [PHP 7.4.19](https://www.php.net/releases/index.php)
* [Apache 2.4.35](http://archive.apache.org/dist/httpd/httpd-2.4.35.tar.gz)
* [MySQL 5.7.24](https://downloads.mysql.com/archives/get/p/23/file/mysql-5.7.24-winx64.zip)
* [Composer](https://getcomposer.org/download/)
* [Symfony](https://symfony.com/download)

## Installing

Follow those steps to make the project run on your machine

Clone the project :
```
git clone https://github.com/mathiiii-dev/BileMo.git
```
Install composer dependencies :
```
composer install
```

## Database & DataFixtures

First edit .env (or create a .env.local to override it) with your database credentials : 
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/bilemo?serverVersion=5.7"
```

Create the database :
```
php bin/console doctrine:database:create
```

Update schema :
```
php bin/console doctrine:schema:update --force
```

Load some data into the database : 
```
php bin/console doctrine:fixtures:load
```

## JWT Config

Edit .env (or .env.local) : 
```
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=
```

Generate SSL key : 
```
php bin/console lexik:jwt:generate-keypair
```
or like this : 
```
openssl genrsa -out config/jwt/private.pem 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

## Test account

You can test the API with those credentials : 
```
Pseudo : Mathias
Password : password
```

## Launch project

Using Symfony CLI :
```
symfony serve
```

or :
```
php bin/console server:start
```

## Project Test

If you want to test this project you have two options : 

You can test this via Postman by downloading this collection :
[Collection postman bilemo](https://github.com/mathiiii-dev/BileMo/files/6926310/MICHELI_Mathias_BileMo.postman_collection.zip)

Or you can test it via an frontend app I've made with Nuxt.JS : 
https://bilemo-frontend.herokuapp.com/

Frontend app Github Repository : 
https://github.com/mathiiii-dev/bilemo-frontend


## Built With

* [Symfony](https://symfony.com/) - Framework PHP
* [LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle) - JWT Bundle
* [JWTRefreshTokenBundle](https://github.com/markitosgv/JWTRefreshTokenBundle) - Refresh JWT Bundle
* [BazingaHateoasBundle](https://github.com/willdurand/BazingaHateoasBundle) - Richardson Model
* [NelmioCorsBundle](https://symfony.com/doc/current/testing.html) - CORS Bundle
* [Swagger-PHP](https://symfony.com/) - API Documentation


## Versioning

For the versions available, see the [tags on this repository](https://github.com/mathiiii-dev/bilemo/tags). 

## Authors

* **Mathias Micheli** - *Student* - [Github](https://github.com/mathiiii-dev)

