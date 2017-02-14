FROM php:7-fpm-alpine
MAINTAINER David Nuñez <dnunez24@gmail.com>

ENV CRAFT_VERSION latest

RUN apk add --no-cache --virtual .build-deps \
    autoconf \
    build-base \
    coreutils \
    imagemagick-dev \
    libmcrypt-dev \
    openssl \
  && apk add --no-cache \
    imagemagick \
    libmcrypt \
    libtool \
  && NPROC=$(getconf _NPROCESSORS_ONLN) \
  && docker-php-ext-install -j$NPROC \
    dom \
    mcrypt \
    opcache \
    # pdo \
    pdo_mysql \
    # reflection \
    # spl \
  && printf "\n" | pecl install -o imagick \
  && pecl install -o redis \
  && docker-php-ext-enable \
    imagick \
    redis \
  && curl -sSO https://getcomposer.org/installer -o composer-installer \
  && echo "$(cat installer.sig) installer" | sha384sum -c \
  && php installer \
    --install-dir=/usr/local/bin \
    --filename=composer \
  && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php -r "if (hash_file('SHA384', 'composer-setup.php') === '55d6ead61b29c7bdee5cccfb50076874187bd9f21f65d8991d46ec5cc90518f447387fb9f76ebae1fbbacf329e583e30') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
  && php composer-setup.php \
    --install-dir=/usr/local/bin \
    --filename=composer \
  && php -r "unlink('composer-setup.php');"

RUN wget -O /tmp/craftcms.zip https://craftcms.com/${CRAFT_VERSION}.zip?accept_license=yes \
  && mkdir -p /tmp/craftcms \
  && unzip /tmp/craftcms.zip -d /var/www/html \
  && rm -rf /tmp/* \
  && find /var/www/html -type f -exec chmod g+w {} \; \
  && find /var/www/html -type d -exec chmod g+ws {} \; \
  && chown -R :www-data /var/www/html \
  && apk del .build-deps
