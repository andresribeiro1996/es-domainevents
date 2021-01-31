#!/bin/sh
composer install
php /app/app.php kafka:domain-event-consumer