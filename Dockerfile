# Stage 1: Builder
FROM php:8.2.1-fpm-alpine AS builder

# Install necessary tools for the build
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev

# Install necessary PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy Composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-scripts --no-dev

# Copy source code into the container
COPY . .

# Stage 2: Production
FROM php:8.2.1-fpm-alpine

# Install minimal dependencies
RUN apk update && apk upgrade --no-cache
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    $PHPIZE_DEPS

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install other PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install opcache

WORKDIR /var/www
COPY .env /var/www/.env

# Copy files from the builder stage
COPY --from=builder /app /var/www

# Add user for the Laravel application
RUN addgroup -g 1000 www \
    && adduser -D -u 1000 -G www www \
    && chown -R www:www /var/www \
    && chmod -R 777 /var/www/storage /var/www/bootstrap/cache/ /tmp/

# Copy supervisor, nginx, php, FPM configuration
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/laravel.conf /etc/nginx/sites-enabled/laravel.conf
COPY ./docker/.htpasswd /etc/nginx/.htpasswd
COPY ./docker/laravel.ini /usr/local/etc/php/conf.d/laravel.ini
COPY ./docker/config-fpm.sh /usr/local/bin/config-fpm.sh
COPY ./docker/start.sh /usr/local/bin/start.sh
# COPY ./docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Make the script executable
RUN chmod +x /usr/local/bin/config-fpm.sh
# Remove build dependencies after installation to reduce image size
RUN apk del $PHPIZE_DEPS
RUN chmod +x /usr/local/bin/start.sh

# remove unnecessary software
RUN apk del

# Expose port 80 for the application
EXPOSE 80

# Run the FPM configuration script and start supervisord
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

CMD ["/bin/sh", "-c", "/usr/local/bin/start.sh && /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf"]
