# Gunakan image ringan
FROM php:8.2-fpm-alpine

# Install ekstensi PHP yang diperlukan Laravel
RUN apk add --no-cache \
    nginx \
    bash \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    icu-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www

# Tambahkan setelah WORKDIR /var/www

# Copy custom PHP config
COPY docker/php/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Copy custom FPM pool config
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Salin semua file Laravel ke container
COPY . .

# Jalankan composer install
RUN composer install --optimize-autoloader --no-dev

# Jalankan cache config
RUN php artisan config:cache

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
