FROM php:7.2.28-fpm-alpine3.10

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis xdebug-2.9.2 mbstring \
    && docker-php-ext-enable redis.so
# php-redis
ENV PHPREDIS_VERSION 3.1.6

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

RUN docker-php-source extract \
    && curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/$PHPREDIS_VERSION.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mv phpredis-$PHPREDIS_VERSION /usr/src/php/ext/redis \
    && docker-php-ext-install redis \
    && docker-php-source delete

RUN apk add --update --no-cache libintl icu icu-dev libxml2-dev \
    && docker-php-ext-install intl zip soap opcache

# mcrypt, gd, iconv
RUN apk add --update --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" gd

RUN docker-php-source extract \
    && apk add --no-cache --virtual .phpize-deps-configure $PHPIZE_DEPS \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apk del .phpize-deps-configure \
    && docker-php-source delete

# install bcmath extension
RUN docker-php-ext-install bcmath
RUN ln -fsn /usr/local/bin/php /usr/bin/php
RUN ln -fsn /usr/local/bin/php-config /usr/bin/php-config

ARG LIBRDKAFKA_GIT_SHA1=1f7417d4796e036b8c19f17373f8290ff5c7561f
RUN apk add --update --no-cache alpine-sdk bash python autoconf && \
    git clone -o ${LIBRDKAFKA_GIT_SHA1} https://github.com/edenhill/librdkafka.git /tmp/librdkafka && \
    cd /tmp/librdkafka/ && \
    ./configure && \
    make && \
    make install

# php-rdkafka should be compiled using the same php module as result we are passing
# --with-php-config /usr/local/bin/php-config
ARG PHPCONF_PATH=/usr/local/etc/php/conf.d
ARG RDKAFKA_PHP_GIT_SHA1=abd6b6add8e0b983c27245a59981a9a4b5389139
RUN apk add --update --no-cache pcre-dev && \
    pecl install rdkafka && \
    echo "extension=rdkafka.so" > ${PHPCONF_PATH}/rdkafka.ini

COPY php/conf.d/* /usr/local/etc/php/conf.d/

COPY docker-entrypoint.sh /usr/local/bin/
COPY php/php.ini* /usr/local/etc/php/

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /app

RUN chown -R www-data:www-data /app

RUN chmod 777 /var/log

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT ["docker-entrypoint.sh"]

VOLUME [ "/app" ]

EXPOSE 8083

CMD ["php-fpm"]
