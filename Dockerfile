# Gunakan image resmi PHP + Apache
FROM php:8.2-apache

# Salin semua file dari repo ke dalam container
COPY . /var/www/html/

# Izinkan file konfigurasi .htaccess
RUN a2enmod rewrite
