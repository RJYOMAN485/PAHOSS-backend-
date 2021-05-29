<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# PAHOSS SMART PARKING

## Install Dependencies
composer install

## Run Migrations
php artisan migrate

### 1. Run Apache server. 
### 2. Create database name called smart-parking
### 3. Create .env file in root directory
### 4. Copy .env-example to .env file
### 5. Import Credentials (required for admin login)
php artisan db:seed --class AdminSeeder
php artisan db:seed --class UserSeeder
php artisan db:seed --class ParkingSeeder




## If you get an error about an encryption key
php artisan key:generate

## Make sure your register first



