# Управление билетами

Консольное приложение для добавления билетов на события в базу данных

## Документация к приложению

### Подготовка к использованию

1. Загрузить исходный код с GitHub и перейти в директорию проекта

    ```sh
    git clone https://github.com/ploschka/event-tickets.git event-tickets
    cd event-tickets
    ```

2. Загрузить зависимости, используя `composer`

    ```sh
    composer install
    ```

3. Создать `db.prod.env` и заполнить переменные окружения базы данных по примеру `db.env`

    ```sh
    MYSQL_DATABASE=event-tickets
    MYSQL_ROOT_PASSWORD=secret
    MYSQL_PASSWORD=secret
    MYSQL_USER=app
    ```
4. Создать `.env.prod.local` и заполнить переменные окружения для внешнего API и DSN для подключения к базе данных по примеру `.env`

    ```sh
    DATABASE_URL="mysql://app:secret@127.0.0.1:3306/event-tickets?serverVersion=8.3.0&charset=utf8mb4"
    API_URL="https://api.site.com/"
    ```

5. Развернуть базу данных в `docker` и подождать её создания

    ```sh
    docker compose up -d
    ```

6. Применить миграции к базе данных

    ```sh
    ./bin/doctrine migrations:migrate
    ```

### Использование

  ```sh
  main.php <event_id> <event_date> <adult_price> <adult_quantity> <kid_price> <kid_quantity>
  <event_date> format: YYYY-MM-DD
  ```

### Включение режима разработчика

Для перехода в режим разработчика, установить переменную окружения `APP_ENV=dev`

## Задание 2

Оба пункта задания решаются выделением типа билета в отдельную таблицу:

1. Каждый билет считается отдельно, со своим штрих-кодом

2. Возможно добавление новых типов билетов, каждый со своей ценой

Получившаяся ER диаграмма таблиц выглядит следующим образом:

![image](https://github.com/user-attachments/assets/7061a754-8208-4b7c-b4a6-cfb6c6d189c3)

