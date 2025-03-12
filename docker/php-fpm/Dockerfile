FROM php:8.2-fpm

# Install required system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    curl \
    openssl \
    supervisor \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    libpcre3-dev \
    zlib1g-dev \
    zlib1g-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    mbstring \
    opcache \
    sockets \
    pcntl \
    bcmath \
    dom \
    fileinfo \
    gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Allows Git to safely operate within the specified directory, `/var/www/html`.
# This is useful for avoiding 'fatal: unsafe directory' errors when working with Git in Docker or other non-standard environments.
RUN git config --global --add safe.directory /var/www/html

# Set ownership to www-data for writable directories
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
