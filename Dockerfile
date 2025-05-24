FROM php:8.2-fpm

# Define arguments with default values
ARG user=laravel
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

    
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip
    
# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN if ! getent group $user >/dev/null; then \
    groupadd -g $uid $user; \
    fi && \
    if ! getent passwd $user >/dev/null; then \
    useradd -u $uid -g $user -G www-data -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $uid:$uid /home/$user; \
    fi

RUN mkdir -p /var/www \
    && mkdir -p /var/www/storage \
    && mkdir -p /var/www/bootstrap/cache \
    && chown -R $uid:$uid /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Set working directory
WORKDIR /var/www

USER $user