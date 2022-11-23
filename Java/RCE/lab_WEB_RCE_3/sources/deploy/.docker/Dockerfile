FROM php:7.2-fpm

ENV OPENSSL_CONF=/etc/ssl/

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        iputils-ping \
        ca-certificates \
        openssl phantomjs libssl-dev \
        bzip2 \
        libfontconfig \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/


