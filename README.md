<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## How to use
- Make sure you already install composer and php in your computer
- Clone this repo
- Do ```composer install``` / ```composer update``` inside the cloned folder
- Copy the .env.example to .env and change the variable to your environment
- Do ```php artisan migrate```
- Do ```php artisan db:seed``` for generate users
- Run the application with ```php artisan serve```
- Access the application from your browser using localhost:{env.port}

## How to feed and post data from API
- Use the endpoint ```/auth/signup``` for create a user from payload
- Use the endpoint ```/auth/login``` for login as a user
- Use the endpoint ```/user/userlist``` for a list of users that registered in database


## Test
- Use ```php artisan test``` for unit testing
