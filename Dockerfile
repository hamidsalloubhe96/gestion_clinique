FROM php:8.4-cli

# Dépendances système
RUN apt-get update && apt-get install -y \
    git curl libpq-dev libzip-dev zip unzip nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

EXPOSE 10000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000