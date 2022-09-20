# taskmanagementsystem

This project was generated with [Laravel](https://laravel.com/) version 9.30.1

# Setting Environment

1.change .env like that
```
DB_CONNECTION= "your connection"
DB_HOST= "your host"
DB_PORT= "your port"
DB_DATABASE= "your database"
DB_USERNAME= "your database's user name"
DB_PASSWORD= "your database's password"
```

2.type `composer install` at your command line

3.type `php artisan key:generate` at your command line

4.type `php artisan migrate` at your command line

5.type `php artisan serve` at your command line

# Call the register route from postman for your user name and password

```
[GET] http://127.0.0.1:8000/api/register
```
