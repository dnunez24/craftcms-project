#!/bin/sh

chown -R www-data:www-data /var/www/html
envsubst '$$COMPOSE_PROJECT_NAME' < /etc/nginx/conf.d/default.tmpl > /etc/nginx/conf.d/default.conf
exec nginx -g 'daemon off;'
