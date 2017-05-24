FROM php:7.1-fpm
# FROM php:7.1.4-fpm
MAINTAINER David Nuñez <dnunez24@gmail.com>

ENV COMPOSER_HOME /var/www/html/.composer

RUN runDeps=" \
        git \
        libmagickwand-6.q16-2 \
        libmcrypt4 \
        libpng12-0 \
    " \
    && buildDeps=" \
        libmagickwand-dev \
        libmcrypt-dev \
        libpng12-dev \
	" \
    && apt-get update && apt-get install -y \
        $buildDeps \
        $runDeps \
        --no-install-recommends && rm -r /var/lib/apt/lists/* \
    && printf "\n" | pecl install -o \
        imagick \
        redis \
        xdebug \
    && docker-php-ext-install -j$(nproc) \
        gd \
        mcrypt \
        pdo_mysql \
        zip \
    && docker-php-ext-enable \
        redis \
        imagick \
        opcache \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false $buildDeps

RUN echo "$(curl https://composer.github.io/installer.sig)  composer-setup.php" > composer-setup.php.sig \
    && curl -o composer-setup.php https://getcomposer.org/installer \
    && sha384sum -c composer-setup.php.sig \
    && php composer-setup.php \
        --install-dir=/usr/local/bin \
        --filename=composer \
    && rm composer-setup.php* \
    && mkdir -p /var/www/html

ADD . /var/www/html

RUN composer install --prefer-dist \
    && find /var/www/html -type f -exec chmod g+w {} \; \
    && find /var/www/html -type d -exec chmod g+ws {} \; \
    && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html
USER www-data
