<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Podcast Management with Laravel

Steps to configure project

- Take latest checkout from repo and you have to use master branch.
- Create your database on MySQL.
- Rename .evn.example with .env file.
- Change the database setting on .env file according to your MySQL configuration.
- Run artisan command : composer update.
- Run artisan command : php artisan migrate.
- Run artisan command : php artisan db:seed --class=PodcastsTableSeeder. For adding some seeds on podcasts table
- [Check documentation for API request and response](https://github.com/prakashmalviya/podcast/wiki).
