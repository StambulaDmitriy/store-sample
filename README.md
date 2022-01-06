## Развёртывание приложения

1. Выполнить `composer install`
2. Выполнить `npm install && npm run dev`
3. Скопировать файл конфигурации `cp .env.example .env`
4. Сформировать ключ приложения `php artisan key:generate`
5. Создать базу данных MySQL
6. Указать настройки для подключения к базе данных в файле `.env`: DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME,
DB_PASSWORD
7. Запустить миграцию для создания таблиц в БД и заполнения их рыбой `php artisan migrate --seed`
8. Для доступа в админ панель необходимо зарегистрировать аккаунт

