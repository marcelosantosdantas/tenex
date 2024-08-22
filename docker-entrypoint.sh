#!/bin/bash

cd /var/www/teste
# Executa o composer install
composer clear-cache
composer install --prefer-dist --no-interaction --optimize-autoloader

# Executa as migrações
php artisan migrate --force

# Inicia o servidor
php -S 0.0.0.0:8000 -t public
