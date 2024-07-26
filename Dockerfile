FROM php:8.0-fpm-alpine

WORKDIR  /var/www

RUN apk update && apk add \
    build-base \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    zip \
    vim \
    unzip \
    git \
    jpegoptim optipng pngquant gifsicle \
    curl \ 
    mysql-client \
    bash \
    npm
RUN docker-php-ext-install sockets
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd  --with-freetype=/usr/include/ --with-jpeg=/usr/include/ 
RUN docker-php-ext-install gd

RUN apk add autoconf && pecl install -o -f redis \
&& rm -rf /tmp/pear \
&& docker-php-ext-enable redis && apk del autoconf

# Copy php configs
COPY ./docker/php.ini /usr/local/etc/php/conf.d/local.ini



# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN addgroup -g 655 -S www && \
#     adduser -u 655 -S www -G www

#create vendor folder
# RUN mkdir /var/www/vendor
# RUN chown www /var/www/vendor
# Copy existing application directory permissions and content
# COPY --chown=www:www . /var/www
COPY . /var/www

# add root to www group
# RUN chmod -R ug+w /var/www/storage

# Deployment steps
RUN composer install --optimize-autoloader --no-dev


RUN chown 655:655 -R /usr/local/etc/php/conf.d

COPY ./docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

COPY ./docker/entrypoint-schedule.sh /entrypoint-schedule.sh
RUN chmod +x /entrypoint-schedule.sh
RUN echo 'request_terminate_timeout = 180' >> /usr/local/etc/php-fpm.d/www.conf

# Expose port 9000 and start php-fpm server
EXPOSE 9000
# You can switch user after this

# USER www

ENTRYPOINT ["/entrypoint.sh"] 