FROM debian:bullseye

RUN apt-get update && \
    apt-get install -y --no-install-recommends locales && \
    rm -rf /var/lib/apt/lists/*

RUN echo "Europe/Budapest" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

ADD locale.gen /etc/locale.gen
RUN locale-gen
ENV LC_CTYPE en_US.UTF-8

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    apt-transport-https lsb-release ca-certificates gpg dirmngr \
    wget \
    unzip \
    vim && \
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    apt-get purge -y --auto-remove wget && \
    rm -rf /var/lib/apt/lists/*

RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
RUN echo "deb-src https://packages.sury.org/php/ $(lsb_release -sc) main" >> /etc/apt/sources.list.d/php.list

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    php8.1-cli \
    php8.1-mbstring \
    php8.1-curl \
    php8.1-intl \
    php8.1-xdebug \
    php8.1-xml \
    php8.1-dev \
    php-pear \
    && rm -rf /var/lib/apt/lists/*

ADD php.ini /etc/php/8.1/cli/php.ini

WORKDIR /var/www/app

RUN php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === trim(file_get_contents('https://composer.github.io/installer.sig'))) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN mkdir -p /var/www/.composerhost
RUN mkdir -p /var/www/.composer

RUN ln -s /var/www/.composerhost/auth.json /var/www/.composer/auth.json
RUN ln -s /var/www/.composerhost/cache /var/www/.composer/cache
VOLUME /var/www/.composerhost

ENTRYPOINT ["tail", "-f", "/dev/null"]
