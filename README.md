# Gallery File test


<a href="https://travis-ci.org/cretueusebiu/laravel-vue-spa"><img src="https://travis-ci.org/cretueusebiu/laravel-vue-spa.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/cretueusebiu/laravel-vue-spa"><img src="https://poser.pugx.org/cretueusebiu/laravel-vue-spa/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/cretueusebiu/laravel-vue-spa"><img src="https://poser.pugx.org/cretueusebiu/laravel-vue-spa/v/stable.svg" alt="Latest Stable Version"></a>



<p align="center">
<img src="https://i.imgur.com/NHFTsGt.png">
</p>

## Features

- Laravel 5.8 
- Vue + VueRouter + Vuex + VueI18n + ESlint
- Pages with dynamic import and custom layouts
- Login, register, email verification and password reset
- Authentication with JWT
- Socialite integration
- Bootstrap 4 + Font Awesome 5
- Docker Environment

## Installation

- `composer create-project --prefer-dist cretueusebiu/laravel-vue-spa`
- Edit `.env` and set your database connection details
- (When installed via git clone or download, run `php artisan key:generate` and `php artisan jwt:secret`)
- `php artisan migrate`
- `npm install`

## Docker (Optional)
- go to folder docker
- `docker-compose build`
- `docker-compose start`
- ssh in to your container and go to folder code and run `composer update`
- run `php artisan key:generate` and `php artisan jwt:secret`
- `php artisan migrate`
- `npm install`

## Usage

Update your .env file
- DB_CONNECTION=mysql
- DB_HOST=DATABASE IP
- DB_PORT=DATABASEPORT
- DB_DATABASE=DATABASENAME
- DB_USERNAME=USERNAME
- DB_PASSWORD=PASSWORD
#### Development

```bash
# build and watch
npm run watch

# serve with hot reloading
npm run hot
```

#### Production

```bash
npm run production
```

## Socialite

This project comes with GitHub as an example for [Laravel Socialite](https://laravel.com/docs/5.8/socialite).

To enable the provider create a new GitHub application and use `https://example.com/api/oauth/github/callback` as the Authorization callback URL.

Edit `.env` and set `GITHUB_CLIENT_ID` and `GITHUB_CLIENT_SECRET` with the keys form your GitHub application.

For other providers you may need to set the appropriate keys in `config/services.php` and redirect url in `OAuthController.php`.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
