# ====================
# Build Stage
# ====================
FROM composer:2.7 AS build

WORKDIR /app

COPY composer.json composer.lock* ./

RUN composer install --prefer-dist --no-interaction

COPY . .

# ====================
# App Runtime Stage
# ====================
FROM php:8.1-cli AS app

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install zip

WORKDIR /app

COPY --from=build /app /app

CMD ["tail", "-f", "/dev/null"]
