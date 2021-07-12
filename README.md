# P7 OC DA/PHP - Symfony

Create a web service exposing an API

## Getting Started

These instructions will get you a copy of the project up and running on your local machine if you want to test it or develop something on it.

### Prerequisites

To make the project run you will need to install those things :

* [Laragon](https://laragon.org/download/)
* [PHP 7.4.19](https://www.php.net/releases/index.php)
* [Apache 2.4.35](http://archive.apache.org/dist/httpd/httpd-2.4.35.tar.gz)
* [MySQL 5.7.24](https://downloads.mysql.com/archives/get/p/23/file/mysql-5.7.24-winx64.zip)
* [Composer](https://getcomposer.org/download/)

### Installing

Follow those steps to make the projetc run on your machine

Clone the project :
```
git clone https://github.com/mathias73/BileMo.git
```
Install composer dependencies :
```
composer install
```

### Database & DataFixtures

First edit .env (or .env.local) with your database credentials : 
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/SnowTricks?serverVersion=5.7"
```

Create the database :
```
php bin/console doctrine:create:database
```

You can load some data into the database : 
```
php bin/console doctrine:fixtures:load
```

## Test account

You cna test the API with those credentials : 
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

## Built With

* [Symfony](https://symfony.com/) - Framework PHP

## Versioning

For the versions available, see the [tags on this repository](https://github.com/mathiiii-dev/bilemo/tags). 

## Authors

* **Mathias Micheli** - *Student* - [Github](https://github.com/mathiiii-dev)

