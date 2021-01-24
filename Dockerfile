FROM php:7.4-cli
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY / /github/workflow/
RUN cd /github/workflow && composer install
RUN apt-get update
RUN apt-get install -y git
RUN chmod +x /github/workflow/entrypoint.sh
ENTRYPOINT ["/github/workflow/entrypoint.sh"]
