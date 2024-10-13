FROM webdevops/php-apache-dev:8.3-alpine

# Environment variables
ENV PHP_INI_DIR /usr/local/etc/php
ENV TZ="Europe/Zaporozhye"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
ENV APACHE_LOG_DIR=/var/www/logs
ENV APPLICATION_USER=application APPLICATION_GROUP=application

ENV APPLICATION_PATH=/public
ENV APACHE_RUN_USER=application APACHE_RUN_GROUP=application

# Add PHP configuration
#ADD ./php.ini $PHP_INI_DIR/
COPY ./conf/ /opt/docker/
#COPY ./conf/usr/local/php

# Composer configuration
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV LD_PRELOAD=/usr/lib/preloadable_libiconv.so

# Install dependencies
ARG DEPS="curl wget runit tzdata freetype-dev libgd libjpeg-turbo-dev libmcrypt-dev libpng-dev postgresql-client libzip-dev nodejs npm"
RUN apk add --update --no-cache $DEPS

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
  && php composer-setup.php --install-dir=/usr/local/bin --filename=composer


# Clear and configure logs
RUN rm -rf /var/www/logs && mkdir /var/www/logs
RUN ln -sf /dev/stdout /var/www/logs/access.log && ln -sf /dev/stderr /var/www/logs/error.log

# Set user and group ownership
RUN chown -R $APPLICATION_USER:$APPLICATION_GROUP /var/www/localhost/htdocs/
RUN chown -R $APPLICATION_USER:$APPLICATION_GROUP /var/www/logs/

WORKDIR /var/www/localhost/htdocs/

EXPOSE 9000
ENTRYPOINT ["/entrypoint"]
CMD ["supervisord"]

# Separate development environment installation (optional)
# This section can be commented out if not needed
ENV WEB_DOCUMENT_ROOT=/var/www/localhost/htdocs/public
ENV WEB_DOCUMENT_INDEX=index.php
ENV WEB_ALIAS_DOMAIN=*.local
ENV WEB_NO_CACHE_PATTERN=\.(css|js|gif|png|jpg|svg|json|xml)$
ENV WEB_PHP_SOCKET=127.0.0.1:9000

RUN set -x \
  && apk add --update --no-cache make autoconf g++ \
  && apk del -f --purge autoconf g++ make