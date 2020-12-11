FROM php:7.4-cli
COPY src/phpunit-coverage-badge.php /phpunit-coverage-badge.php
CMD ["php", "/phpunit-coverage-badge.php"]