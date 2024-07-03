# Laravel API - Хранение и обработка информации об оборудовании
## Требования
- Laravel 11.x требует, как минимум, версию PHP 8.2.
- Composer
## Установка
1. Скачайте проект:
   - Вариант 1: скачайте [архив](https://github.com/TheKompreso/answer-lara-equipment-api/archive/refs/heads/master.zip) с проектом  и разархивируйте в нужную папку.
   - Вариант 2: с помощью git clone:
```
git clone https://github.com/TheKompreso/answer-lara-equipment-api
```
2. Обновите зависимости проекта. В консоли перейдите в каталог, где лежит composer.json, и выполните команду:
```
composer update
```
3. Настройте файл .env, а именно связь с вашей базой данных MySQL. Найдите строчку '<b>DB_CONNECTION=sqlite</b>' и настройте её и следующие строчки следующим образом:
```
DB_CONNECTION=mysql
DB_HOST=YOUR_database_host
DB_PORT=3306
DB_DATABASE=YOUR_laravel_db
DB_USERNAME=YOUR_laravel_user
DB_PASSWORD=YOUR_password
```
