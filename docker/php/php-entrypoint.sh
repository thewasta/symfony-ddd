#!/bin/sh
set -e

if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

INIT=$(command)

for x in php-fpm php bin/console; do
  if [ "$1" = "$x" ]; then
    INIT=$x
  fi
done
if [ "$1" = "$INIT" ]; then
  mkdir -p var/cache var/log
#  setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
  chown -R www-data:www-data var
#  setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var
  chown -R www-data:www-data var
  if [ "$APP_ENV" != 'pro' ]; then
      composer install --ignore-platform-req=php --prefer-dist --no-progress --no-interaction
  fi
fi
exec docker-php-entrypoint "$@"