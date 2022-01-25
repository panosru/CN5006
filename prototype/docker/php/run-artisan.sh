#!/bin/sh

cd /var/www/html/api
#composer install
#php artisan migrate:refresh --seed

service supervisor stop
service supervisor start
supervisorctl reread
supervisorctl update
supervisorctl start api-worker:*
supervisorctl status api-worker:*
