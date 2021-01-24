FROM php:7.4-cli
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
COPY entrypoint.sh /github/workflow/entrypoint.sh
COPY src/ /github/workflow/src
COPY vendor/ /github/workflow/vendor
RUN apt-get update
RUN apt-get install -y git
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/github/workflow/entrypoint.sh"]
