#!/bin/sh
php artisan migrate --force
exec /usr/bin/supervisord -c /etc/supervisord.conf
