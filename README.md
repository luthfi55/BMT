<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

- Copy env.example, paste it as .env, and customize it for your device.
```
cp .env.example .env
```
- Installing Dependencies with Composer
```
composer install
```
- Running Database Migrations and Seeding
```
php artisan migrate --seed
```
- Generating Passport Encryption Keys
```
php artisan passport:keys
```
- Starting the Development Server
```
php artisan serve
```
## Usage Guide 

**<h4> Admin Account </h4>**

Admin 1 <br>
Email        : admin@gmail.com        
Password     : admin123

Admin 2 <br>
Email        : admin2@gmail.com        
Password     : admin123

**<h4> Automatic Monthly Updates for Installations </h4>**

Run          : <br>
```
php artisan schedule:work
```
