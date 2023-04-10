<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Steps to Run

Clone the project using below command
``` 
git clone https://github.com/sahamnadeem/Krews.git
```

Execute following command in the same sequance
``` 
cp .env.example .env
composer install
php artisan key:generate
php artisan config:cache
```
Then migrate database 

```
php artisan migrate
```
As the application is using Laravel passport, we need to install the keys.

```
php artisan passport:install
```

Finally, the admin user can be created via below command

```
php artisan make:admin {name} {email} {password}
```
this command will create a valid admin user which can be later logged in via Web Portal.

### Unit Testing

Unit testing can be performed by executing following command

```
php artisan test --stop-on-failure