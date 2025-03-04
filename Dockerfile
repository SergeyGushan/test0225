# Используем официальный образ PHP 8.4 с FPM (FastCGI Process Manager)
FROM php:8.4-fpm

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем все файлы проекта в контейнер
COPY . /var/www/html

# Рабочая директория теперь внутри backend
WORKDIR /var/www/html/backend

# Устанавливаем зависимости через Composer
RUN composer install

# Копируем конфигурацию для Nginx
COPY ./nginx/default.conf /etc/nginx/sites-available/default

# Настройка прав на файлы
RUN chown -R www-data:www-data /var/www/html

# Открываем порты для Nginx
EXPOSE 80

# Запускаем Nginx и PHP-FPM
CMD service nginx start && php-fpm
