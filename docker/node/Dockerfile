FROM ubuntu:18.04

ARG UID
ARG GID
ARG TZ

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get upgrade && apt-get update && \
    apt-get install -y \
    wget \
    htop \
    git \
    curl \
    vim \
    apt-transport-https \
    unzip \
    sudo \
    nodejs \
    nginx

RUN curl https://www.npmjs.com/install.sh | sudo sh && npm install -g @vue/cli

COPY nginx/front /etc/nginx/sites-available/default

RUN echo "daemon off;" >> /etc/nginx/nginx.conf


WORKDIR /app

RUN groupadd -g $GID node && \
    useradd -u $UID node -g  node -s /bin/bash -d /app && \
    chown -R node:node /app


RUN su -c "npm config set registry http://registry.npmjs.org/" node

CMD nginx && su -c "npm install && npm run build " node