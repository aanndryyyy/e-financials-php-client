# Cursor Cloud Agent base image for e-financials/php-client
# PHP 8.4 matches CI / Pest 5 tooling (runtime requirement is ^8.2).
FROM php:8.4-cli-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        sudo \
        unzip \
        curl \
        ca-certificates \
        libzip-dev \
        libxml2-dev \
        $PHPIZE_DEPS \
    && docker-php-ext-install -j"$(nproc)" zip \
    && pecl install pcov \
    && docker-php-ext-enable pcov \
    && apt-get purge -y --auto-remove $PHPIZE_DEPS \
    && rm -rf /var/lib/apt/lists/*

# Composer 2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Non-root user with passwordless sudo (matches Cursor agent conventions)
RUN useradd --create-home --shell /bin/bash ubuntu \
    && echo 'ubuntu ALL=(ALL) NOPASSWD:ALL' > /etc/sudoers.d/ubuntu \
    && chmod 0440 /etc/sudoers.d/ubuntu

USER ubuntu
WORKDIR /workspace
