FROM php:7.4-cli
COPY entrypoint.sh /entrypoint.sh
COPY src/ /src/
RUN apt-get update
RUN apt-get install -y git
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
