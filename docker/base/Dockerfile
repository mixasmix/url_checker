FROM php:8-alpine

RUN apk add --no-cache \
        php8 \
        php8-fpm \
        libressl-dev  \
        postgresql-dev  \
        mc \
        nano \
        php8-ctype \
        php8-xmlreader \
        php8-xmlwriter \
        php8-fileinfo  \
        php8-gd  \
        php8-simplexml  \
        php8-bcmath \
        php8-redis \
        php8-curl \
        php8-xml \
        php8-zip \
        php8-dom \
        php8-mbstring \
        php8-sockets \
        php8-openssl \
        php8-phar \
        php8-iconv \
        php8-tokenizer \
        php8-pdo_pgsql \
        php8-pgsql \
        php8-session \
        curl
RUN docker-php-ext-install pdo pdo_pgsql

CMD ["php-fpm8", "-F"]

COPY . ./symfony

WORKDIR "/symfony"

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --ignore-platform-reqs

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

RUN echo "clear_env = no" >> /etc/php8/php-fpm.d/www.conf \
    && sed -i -e 's/user = nobody.*/user = www-data/' /etc/php8/php-fpm.d/www.conf \
    && sed -i -e 's/group = nobody.*/group = www-data/' /etc/php8/php-fpm.d/www.conf \
    && sed -i -e 's/;listen.owner = nobody.*/listen.owner = www-data/' /etc/php8/php-fpm.d/www.conf \
    && sed -i -e 's/;listen.group = nobody.*/listen.group = www-data/' /etc/php8/php-fpm.d/www.conf \
    && sed -i -e 's/pm.max_children = 5.*/pm.max_children = 25/' /etc/php8/php-fpm.d/www.conf \
    && sed -i -e 's/memory_limit = 128M.*/memory_limit = 1024M/' /etc/php8/php.ini \
    && sed -i -e 's/upload_max_filesize = 2M.*/upload_max_filesize = 100M/' /etc/php8/php.ini \
    && sed -i -e 's/post_max_size = 8M.*/post_max_size = 108M/' /etc/php8/php.ini
