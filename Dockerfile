## Install Stage
FROM php:fpm-alpine3.12 AS installer

# Install composer
RUN set -eux;\
    \
    curl -o composer-setup.php https://getcomposer.org/installer -L; \
    php composer-setup.php --install-dir=/usr/local/bin/ --filename=composer; \
    rm -f composer-setup.php; \
    chmod +x /usr/local/bin/composer

WORKDIR /var/www

COPY . .

RUN composer -V \
    && composer install --no-dev --no-progress -o


## final build
FROM php:fpm-alpine3.12

WORKDIR /var/www

COPY --from=installer /var/www. .
