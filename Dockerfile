FROM php:7.4-cli
# Install Composer
RUN apt-get update
RUN apt-get install -y git libicu-dev && docker-php-ext-configure intl && docker-php-ext-install intl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . /
RUN ls -l && composer install
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
