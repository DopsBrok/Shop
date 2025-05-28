# 1. Берём официальный PHP-образ с нужной версией
FROM php:8.1-cli

# 2. Подключаем расширения PDO для MySQL
RUN docker-php-ext-install pdo pdo_mysql

# 3. (Опционально) Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# 4. Устанавливаем рабочую папку внутри контейнера
WORKDIR /app

# 5. Копируем ВСЁ из вашего репо в контейнер
COPY . .

# 6. Устанавливаем PHP-зависимости
RUN composer install --no-dev --optimize-autoloader

# 7. Открываем порт 10000 для встроенного сервера
EXPOSE 10000

# 8. Команда, которая запускается при старте контейнера
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]