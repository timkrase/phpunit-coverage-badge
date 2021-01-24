FROM php:7.4-cli
# Install Composer
RUN apt-get update
RUN apt-get install -y git zip unzip libzip-dev libicu-dev && docker-php-ext-configure intl && docker-php-ext-install intl zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . /srv/
RUN cd srv && ls -l && composer install
RUN chmod +x /srv/entrypoint.sh
ENTRYPOINT ["/srv/entrypoint.sh"]
