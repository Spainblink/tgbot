FROM php:8.1-apache

# Включаем модуль SSL
RUN a2enmod ssl

# Копируем конфигурацию виртуального хоста
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Копируем сертификаты в контейнер
COPY ./certs/fullchain1.pem /etc/ssl/certs/origin_certificate.pem
COPY ./certs/privkey1.pem /etc/ssl/private/origin_private.key

# Открываем порт 443
EXPOSE 443
