FROM php:7.4-fpm

RUN apt clean all
RUN apt update
RUN apt install -y libxml2-dev libpng-dev libwebp-dev libfreetype6-dev libjpeg62-turbo-dev
RUN apt install -y libzip-dev zip
RUN apt install -y build-essential libmagickwand-dev
RUN apt clean all
RUN pecl install imagick

RUN apt install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN docker-php-ext-install xml
# RUN docker-php-ext-install imagick

RUN docker-php-ext-enable pdo_pgsql
RUN docker-php-ext-enable imagick

RUN docker-php-ext-configure zip
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp 

# install composer 
# COPY --from=composer/composer:2.2.18 /usr/bin/composer /usr/bin/composer
RUN php -r " copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php — install-dir=/usr/local/bin — filename=composer \
&& php -r "unlink('composer-setup.php');" && \
mv composer.phar /usr/local/bin/composer;

# ADD ./docker/php.ini /usr/local/etc/php/php.ini

ADD ./backend/docker/7.4/start-container /usr/local/bin/start-container
ADD ./backend/docker/7.4/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ADD ./backend/docker/7.4/php.ini /usr/local/etc/php/php.ini

# set time zone
ENV TZ=Asia/Jakarta
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www

RUN chmod +x /usr/local/bin/start-container

EXPOSE 8001