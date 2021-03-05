############################
#
# build for web app
#
############################
FROM litsoftware/php:8-fpm AS fpm

WORKDIR /var/www

COPY . .

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


############################
#
# build for laravl
#
############################
FROM litsoftware/php:8-cli AS cli

WORKDIR /var/www

COPY --from=fpm /var/www/.  /var/www
COPY /var/www/docker/start.sh /usr/local/bin/start
RUN chomd +x /usr/local/bin/start

CMD ["/usr/local/bin/start"]


############################
#
# build for laravl
#
############################
FROM nginx:latest AS web

WORKDIR /var/www

COPY --from=fpm /var/www/.  /var/www
