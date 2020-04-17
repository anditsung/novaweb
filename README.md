## membuat project baru dengan framework laravel versi 6 paling baru
composer create-project laravel/laravel [PROJECT] "^6"

## install laravel nova ke project
composer config repositories.nova path ../nova2
composer require laravel/nova=^2

## install novaweb ke project
if using folder
```composer config repositories.novaweb path ../novaweb```
composer require tsung/novaweb
php artisan novaweb:install

## migrate database
php artisan migrate

## create user on nova
php artisan nova:user

