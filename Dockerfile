FROM php:7.4-fpm AS vendor
WORKDIR /tmp/
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN apt update -qq -y && apt install -qq zip libicu-dev  -y \
&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& docker-php-ext-install intl > /dev/null && \
composer update --quiet && composer install --quiet && \
composer require symfony/translation > /dev/null && \
composer require doctrine/annotations > /dev/null && \
composer require symfony/orm-pack > /dev/null && \
composer require symfony/dotenv > /dev/null


# stage of run
FROM php:7.4-apache
RUN apt-get update -qq && apt-get install -qq -y build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev

#ENV APACHE_DOCUMENT_ROOT=/var/www/html
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html
RUN chown -R www-data:www-data /var && chmod -R g+rw /var
COPY .htaccess /var/www/html/public/
COPY --from=vendor /tmp/vendor/ /var/www/html/vendor/
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-configure gd > /dev/null && docker-php-ext-install gd > /dev/null




#ENV APP_ENV=prod
#ENV APP_DEBUG=0 
#RUN php bin/console cache:clear