FROM ghcr.io/timkrase/phpunit-coverage-badge:v1.0.0
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]