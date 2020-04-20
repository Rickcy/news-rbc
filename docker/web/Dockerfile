FROM ubuntu:18.04

ARG UID
ARG GID
ARG TZ


RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && \
  apt-get install -y \
   software-properties-common \
    wget \
    git \
    curl \
    apt-transport-https \
    htop \
    unzip \
    sudo \
    vim
RUN apt-add-repository ppa:ondrej/php && apt-get update && \
        apt-get install -y \
          nginx \
          php7.3 \
          php7.3-intl \
          php7.3-cli \
          php7.3-common \
          php7.3-mysql \
          php7.3-mbstring \
          php7.3-curl \
          php7.3-xml \
          php7.3-sqlite3 \
          php7.3-pgsql \
          php-memcache \
          php-memcached \
          php7.3-gd \
          php-imagick \
          php7.3-fpm \
          php-xdebug \
          php-redis \
          php7.3-zip \
          php7.3-bcmath \
          cron

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

COPY nginx/api /etc/nginx/sites-available/default

RUN echo "daemon off;" >> /etc/nginx/nginx.conf

WORKDIR /app

RUN groupadd -g $GID web && \
    useradd -g $UID  web -s /bin/bash -d /app && \
    chown -R web:web /app


CMD service php7.3-fpm start &&  nginx