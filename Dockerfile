FROM php:5.6-apache
ADD app /app
RUN docker-php-ext-install mysql pdo pdo_mysql
RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev && \
    docker-php-ext-install mbstring && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/  &&  \
    docker-php-ext-install gd
RUN chmod 777 -R /var/www
EXPOSE 8000
