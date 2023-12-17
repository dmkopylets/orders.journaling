FROM webdevops/php-apache-dev:8.1-alpine AS e-journal-php81-apache-Alpine

# PHP_INI_DIR to be symmetrical with official php docker image
ENV PHP_INI_DIR /usr/local/etc/php
ENV TZ "Europe/Kiev"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
ENV APACHE_LOG_DIR /var/www/logs
ENV APPLICATION_USER=application APPLICATION_GROUP=application APPLICATION_PATH=/public
ENV APACHE_RUN_USER=application APACHE_RUN_GROUP=application

COPY ./conf/ /opt/docker/

# When using Composer, disable the warning about running commands as root/super user
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV LD_PRELOAD=/usr/lib/preloadable_libiconv.so

# Persistent runtime dependencies
ARG DEPS="\
        curl \
        wget \
        runit \
        tzdata \
        freetype-dev \
        libgd \
        libjpeg-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        postgresql-client \
        libzip-dev \
        nodejs \
        npm"

RUN set -x \
    && apk add --update --no-cache $DEPS

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer


## монтуєм файл конфигурації php в контейнер
ADD ./php.ini /usr/local/etc/php/

# очищуємо папку логів в контейнері (насправді у прокинутій із-зовні папки)
RUN rm -rf /var/www/logs \
 && mkdir /var/www/logs \
 && ln -sf /dev/stdout /var/www/logs/access.log \
 && ln -sf /dev/stderr /var/www/logs/error.log

#USER application

# Граємося з правами на всякий випадок
RUN chown -R application:application /var/www/localhost/htdocs/
RUN chown -R application:application /var/www/logs/

WORKDIR /var/www/localhost/htdocs/

EXPOSE 9000
ENTRYPOINT ["/entrypoint"]
CMD ["supervisord"]
ENV WEB_DOCUMENT_ROOT=/var/www/localhost/htdocs/public WEB_DOCUMENT_INDEX=index.php WEB_ALIAS_DOMAIN=*.local
ENV WEB_PHP_SOCKET=127.0.0.1:9000
ENV WEB_NO_CACHE_PATTERN=\.(css|js|gif|png|jpg|svg|json|xml)$
ENV WEB_PHP_SOCKET=127.0.0.1:9000

RUN set -x \
    # Install development environment
    && apk-install \
        make \
        autoconf \
        g++ \
#    && pecl install xdebug \
    && apk del -f --purge \
        autoconf \
        g++ \
        make \
    # && docker-php-ext-enable xdebug \
    # && a2enmod rewrite \
    # Enable php development services
    && docker-service enable syslog \
    && docker-service enable postfix \
    && docker-service enable ssh \
    && docker-run-bootstrap \
    && docker-image-cleanup
