FROM php:8.2-fpm

# Install dependencies and necessary software
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    curl \
    nodejs \
    npm && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy the application files
COPY . /var/www

# Ensure artisan is executable
RUN chmod +x /var/www/artisan

# Install PHP dependencies with Composer (no-scripts flag)
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts

# Install Node.js dependencies (npm)
RUN npm install --legacy-peer-deps

# Create a script to run after container starts
RUN echo "#!/bin/bash\n\
php artisan migrate --force\n\
php artisan key:generate\n\
npm run dev\n\
php-fpm" > /usr/local/bin/start.sh

# Make the startup script executable
RUN chmod +x /usr/local/bin/start.sh

# Expose necessary port
EXPOSE 9000

# Set the entrypoint to the custom script
ENTRYPOINT ["/usr/local/bin/start.sh"]
