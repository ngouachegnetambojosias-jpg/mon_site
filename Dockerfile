FROM php:8.2-apache

# Installation des extensions MySQL et SSL nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Activation de la réécriture d'URL Apache
RUN a2enmod rewrite

# Copie des fichiers
COPY . /var/www/html/

# Donner les bonnes permissions aux fichiers
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
