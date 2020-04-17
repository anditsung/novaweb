# Install Novaweb ke Project Laravel

## Install framework laravel
##### Versi 6
>composer create-project laravel/laravel [PROJECT_PATH] "^6"
##### Versi 7
>composer create-project laravel/laravel [PROJECT_PATH] "^7"

## Install Laravel Nova ke project
##### Menambahkan repositori nova ke configurasi composer jika menggunakan folder
>composer config repositories.nova path [NOVA_PATH]
##### Install laravel nova
>composer require laravel/nova

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

