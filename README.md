# Edrisa A. Turay Full Stack Developer REST Api Codes

a small web application to manage a list of Courses. Each course has a name and an author

a full working version can be viewed here at - 

[Frontend Application](http://api-frontend.edrisa.com) and 
[Backend Application](api-backend.edrisa.com)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
PHP > 7.3
MySQL Server
Composer

```

### Installing

A step by step series of examples that tell you how to get a development env running

Using CMD

Change the current working directory to the project directory

```
cd "path-to-directory"/interview_api
```

make sure all libraries are installed by updating composer
in the terminal, run 

```
composer update
```

start the symfony server on port **8000** 

if symfony is installed run (Recommended)

```
symfony server:start
```

or using php cli

```
php -S 127.0.0.1:8000
```

Now it's time setup the database.

## Database Setup

First let's tweak the database url in the .env file

open the .env file and edit this line

```
DATABASE_URL=mysql://db_username:db_password@db_host:db_port/db_name?serverVersion=5.7
```

all is good let's create the database using doctrine

in your terminal, run

```
php bin/console doctrine:database:crate
```
this will create the database interview_api

next is to generate migrations for all of the entities, in the terminal, run;
```
php bin/console make:migration
```
this will generate a file containing all the queries required to build the database and all it's relationships based on the Entities

you can check it out in the **src/Migrations** folder

after generating the migrations, migrate the migration to the database by: 

```
php bin/console doctrine:migrations:migrate
```

now we have our database setup, we can load dummy data into the database by using the DataFixtures created in 

**src/DataFixtures/AppFixtures.php** file

in the terminal, run: 

```
php bin/console doctrine:fixtures:load
```
when prompt with a warning, type **yes** and press enter

this will load dummy courses, students, authors and assign them to a user 

* For the user, with time we will add the jwt authentication to secure the api and will use the user to sign in and manage the API. *but for now the API is open*.

####At this point all is good and you can view the api using 
```
http://localhost:8000/api
```
an extensive api documentation is on this url and you can also see instructions on how to test from that url or using postman. 


###Make sure the server is started and running on 127.0.0.1:8000

##Other Features
* Filtering / Searching (Exact or partial match search)
* API DOC using SwaggerUI and ReDoc (out of the box with the Symfony API Platform)

## Built With

* [Symfony](https://symfony.com/) - The PHP web framework used
* [ApiPlatform](https://api-platform.com/) - Symfony REST API 
* [Doctrine](https://www.doctrine-project.org/projects/orm.html) - PHP object relational mapper (ORM)

## Authors

* **Edrisa A. Turay** 
* Website: https://edrisa.com 
* Github [PaPZzzDNightmaare/interview_api](https://github.com/PaPZzzDNightmare/interview_api)

## Acknowledgments

* Symfony
* Api Platform
* Doctrine
* Fzaninotto Faker

