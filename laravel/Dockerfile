# Image de production basee sur FrankenPHP et PHP 8.3
# Installe les extensions systeme necessaires pour Laravel (MySQL, Redis, GD)
# Configure l'utilisateur non-root pour la securite et prepare Octane pour le mode Worker

FROM dunglas/frankenphp:1.1-php8.3-alpine

RUN install-php-extensions \
    pcntl \
    gd \
    intl \
    zip \
    opcache \
    pdo_mysql \
    redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan octane:install --server=frankenphp

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

USER www-data

ENTRYPOINT ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]
