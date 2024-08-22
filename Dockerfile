FROM php:8.1-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    pkg-config \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql mbstring xml zip pcntl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Torna o script executável
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Criar a pasta vendor e garantir que as permissões estejam corretas
RUN mkdir -p /var/www/teste/vendor && chown -R www-data:www-data /var/www/teste && chmod -R 775 /var/www


RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www

EXPOSE 8000

# CMD ["php", "-S", "0.0.0.0:8000", "-t", "teste/public"]

# Define o script de entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

