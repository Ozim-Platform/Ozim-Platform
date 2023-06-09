# Ozim Platform

<p align="center"><a href="http://ozimplatform.com" target="_blank"><img src="https://static.tildacdn.com/tild6430-6563-4830-b538-363264643761/logo.svg" width="400"></a></p>

## Getting Started 
You are welcome to use the app as is, or you can build it from source.The app is built using Android Studio and the latest version of the Android SDK.
* [PHP 7.3 or newer](https://www.php.net/)
* [Composer 2](https://getcomposer.org/)
* [MongoDB](https://www.mongodb.com/)

### Installing and Setting

Clone the repository below

```
git clone Project
cd ozim
```

Open the project in android studio and sync the dependencies.

## Set Environment params

```
cp .env.example .env
set DB_CONNECTION=mongodb
DB_HOST="host"
DB_PORT=27017
DB_DATABASE="ozim"
DB_USERNAME="Your user"
DB_PASSWORD="password"
```

## Install dependencies

```
- composer install
- php artisan key:generate && php artisan optimize && php artisan config:clear&& php artisan migrate:fresh --seed

Use cron daily at 00:01 for this schedule php artisan check_children_age
```




 