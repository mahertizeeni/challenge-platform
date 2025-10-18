FROM php:8.3-fpm

# تثبيت المتطلبات
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql gd intl zip

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# نسخ المشروع
COPY . .

# إعداد Git للسماح بالوصول إلى المستودع داخل Docker
RUN git config --global --add safe.directory /var/www/html

# تثبيت الحزم
RUN composer install --no-interaction --prefer-dist

# تعيين صلاحيات مجلد التخزين
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
