FROM php:7.1-fpm-buster

ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

ARG TIMEZONE=Europe/Paris

RUN apt-get update && apt-get install -y apt-utils

# Install nginx
RUN apt-get install -y nginx
ADD vhost.conf /etc/nginx/conf.d/default.conf
RUN rm /etc/nginx/sites-enabled/default

RUN apt-get install -y bash \
    libfreetype6-dev \
    libmcrypt-dev \
    zlib1g-dev \
    libicu-dev \
    g++ \
    apt-transport-https \
    zip \
    libzip-dev \
    unzip \
    libxml2-dev \
    wget \
    vim \
    git \
    libmemcached-dev \
    libpq-dev \
    netcat \
    cron \
    wkhtmltopdf xvfb \
    supervisor \
    # for mbstring
    libonig-dev \
    && apt-get clean ; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) iconv \
    bcmath \
    mbstring \
    pdo \
    pdo_mysql \
    dom \
    simplexml \
    opcache \
    intl \
    zip \
    soap \
    gd

RUN pecl install apcu; \
    docker-php-ext-enable apcu

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini && date

ADD php.ini /usr/local/etc/php/conf.d/php-custom.ini
RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer

# install timecop to mock date (see https://github.com/hnw/php-timecop)
RUN pecl install timecop-beta \
     && echo "extension=timecop.so" >> /usr/local/etc/php/conf.d/timecop.ini

# increase the number of processes
RUN echo 'pm.max_children = 100' >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo 'pm.start_servers = 15' >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo 'pm.min_spare_servers = 10' >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo 'pm.max_spare_servers = 20' >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo 'pm.max_requests = 1000' >> /usr/local/etc/php-fpm.d/zz-docker.conf


RUN usermod -u ${DOCKER_USER_ID:-1000} www-data

RUN mkdir /app
WORKDIR /app

RUN /usr/bin/timeout 1s echo "timeout is installed"

ADD start.sh /docker-entrypoint.d/start.sh
RUN chmod +x /docker-entrypoint.d/start.sh
