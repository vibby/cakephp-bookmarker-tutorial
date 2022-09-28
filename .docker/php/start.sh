#!/bin/sh

# Print commands and their arguments as they are executed
set -xe

# Detect the host IP
export DOCKER_BRIDGE_IP=$(ip ro | grep default | cut -d' ' -f 3)

# Composer install
composer install --prefer-dist --no-scripts --no-progress --no-suggest --optimize-autoloader

service nginx start

php-fpm
