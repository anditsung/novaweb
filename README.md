# Install Novaweb ke Project Laravel

## Install framework laravel versi 6
>composer create-project laravel/laravel [PROJECT_PATH] "^6"

## Install Laravel Nova ke project
##### Menambahkan repositori nova ke configurasi composer jika menggunakan folder
>composer config repositories.nova path [NOVA_PATH]
##### Install laravel nova
>composer require laravel/nova=^2

## Install Novaweb ke project
##### Menambahkan repositori novaweb ke configurasi composer jika menggunakan folder
>composer config repositories.novaweb path [NOVAWEB_PATH]
##### Install Novaweb
>composer require tsung/novaweb

>php artisan novaweb:install

## Migrasi database
>php artisan migrate

## Membuat user baru
>php artisan nova:user
