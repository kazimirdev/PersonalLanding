FROM php:8.2-apache

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql 

# Enable Apache mod_rewrite
RUN a2enmod rewrite

COPY . /var/www/html/

WORKDIR /var/www/html/public

# Allow .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/AllowOverride None/s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf