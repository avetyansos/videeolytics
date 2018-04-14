FROM php:7.2-fpm

## Install PHP extensions and dependencies
RUN apt-get update && apt-get install --no-install-recommends -y \
    zip unzip \
    libmcrypt-dev zlib1g-dev libicu-dev g++ libxml2-dev libssl-dev openssl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring intl zip ftp \
    && docker-php-ext-enable pdo pdo_mysql

## Install nginx
RUN apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -q -y \
    gnupg2 dirmngr wget apt-transport-https lsb-release ca-certificates \
#    && apt-key adv --keyserver hkp://pgp.mit.edu:80 --recv-keys ABF5BD827BD9BF62 \
    && wget -qO - http://nginx.org/keys/nginx_signing.key | apt-key add - \
    && echo "deb http://nginx.org/packages/debian/ stretch nginx" >> /etc/apt/sources.list \
    && echo "deb-src http://nginx.org/packages/debian/ stretch nginx" >> /etc/apt/sources.list \
    && apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -q -y nginx vim

## Install nodejs (for npm)
RUN apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -q -y curl \
    && curl -sL https://deb.nodesource.com/setup_8.x | bash - \
    && apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -q -y nodejs

## Install ffmpeg
RUN apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -q -y ffmpeg ffmpegthumbs ffmpegthumbnailer

## Clean repository
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/*

## Forward request and error logs to docker log collector
#RUN ln -sf /dev/stdout /var/log/nginx/access.log \
#	&& ln -sf /dev/stderr /var/log/nginx/error.log

COPY docker-helper/configs/php/*.ini /usr/local/etc/php/conf.d/
## To be sure that PHP will not ignore configs
RUN chmod og-w /usr/local/etc/php/conf.d/*.ini


COPY docker-helper/configs/nginx/*.conf /etc/nginx/conf.d/
## To be sure that Nginx will not ignore configs
RUN chmod og-w /etc/nginx/conf.d/*.conf

RUN mkdir -p /var/www/web
COPY src /var/www/web

COPY docker-helper/start.sh /usr/local/bin/start-web.sh
## Make file executable
RUN chmod +x /usr/local/bin/start-web.sh

COPY docker-helper/composer.phar /usr/local/bin/composer
## Make file executable
RUN chmod +x /usr/local/bin/composer

WORKDIR /var/www/web

# Prepare laravel project
RUN chown -R www-data:www-data storage \
    && composer install \
    && npm install \
    && npm run production

EXPOSE 9000 80 443

STOPSIGNAL SIGTERM

ENTRYPOINT ["/usr/local/bin/start-web.sh"]

#CMD ["nginx", "-g", "daemon off;"]