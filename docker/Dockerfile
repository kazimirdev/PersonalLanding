FROM php:8.2-apache

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql 

# Enable Apache mod_rewrite
RUN a2enmod rewrite

COPY . /var/www/html/

# Allow .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/AllowOverride None/s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Create symlinks for static assets in admin folder
RUN ln -s /var/www/html/public/css /var/www/html/public/admin/css && \
    ln -s /var/www/html/public/js /var/www/html/public/admin/js && \
    ln -s /var/www/html/public/img /var/www/html/public/admin/img && \
    ln -s /var/www/html/public/uploads /var/www/html/public/admin/uploads

# Set default to public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Create a startup script to set document root based on APP_TYPE
RUN echo '#!/bin/bash\n\
if [ "$APP_TYPE" = "admin" ]; then\n\
    sed -i "s|/var/www/html/public|/var/www/html/public/admin|g" /etc/apache2/sites-available/000-default.conf\n\
fi\n\
apache2-foreground' > /usr/local/bin/docker-entrypoint.sh && chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]