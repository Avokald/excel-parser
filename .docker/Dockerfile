FROM php:7.4-apache-buster

RUN apt-get update && apt-get install -y \
    build-essential \
    libfreetype6-dev \
    locales \
    libzip-dev \
    zip \
    vim \
    unzip \
    git \
    curl \
    supervisor

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt install -y nodejs

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd \
          --with-freetype

RUN docker-php-ext-install pdo_mysql zip exif pcntl bcmath gd opcache sockets

COPY . /var/www/html
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/start.sh /usr/local/bin/start
COPY .docker/laravel-worker.conf /etc/supervisor/conf.d

RUN chown -R www-data:www-data /var/www/html \
    && chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

CMD ["/usr/local/bin/start"]
