FROM php:7-fpm-alpine
MAINTAINER David Nuñez <dnunez24@gmail.com>

RUN apk add --no-cache --virtual .build-deps \
    autoconf \
    build-base \
    coreutils \
    imagemagick-dev \
    libmcrypt-dev \
    wget \
  && apk add --no-cache \
    imagemagick \
    libmcrypt \
    libtool \
  && NPROC=$(getconf _NPROCESSORS_ONLN) \
  && docker-php-ext-install -j$NPROC \
    dom \
    mcrypt \
    opcache \
    pdo_mysql \
  && printf "\n" | pecl install -o imagick \
  && pecl install -o redis \
  && docker-php-ext-enable \
    imagick \
    redis

RUN mkdir -p /var/www/html \
  && echo "$(wget -q -O - https://composer.github.io/installer.sig)  composer-setup.php" > composer-setup.php.sig \
  && wget -q -O composer-setup.php https://getcomposer.org/installer \
  && sha384sum -c composer-setup.php.sig \
  && php composer-setup.php \
    --install-dir=/usr/local/bin \
    --filename=composer \
  && rm composer-setup.php* \
  && find /var/www/html -type f -exec chmod g+w {} \; \
  && find /var/www/html -type d -exec chmod g+ws {} \; \
  && chown -R :www-data /var/www/html \
  && apk del .build-deps

WORKDIR /var/www/html
USER www-data
