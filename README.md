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
2. Обновите зависимости проекта. В консоли перейдите в корневую папку с проектом и выполните команду:
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
4. Запустите миграцию базы данных
```
php artisan migrate
```

## API-методы
### GET: /api/equipment
Получить список оборудования.

Query Parameter   | Type   | Description
----------------- |--------| ------------------------------------------------------------------
``q``        | string | Укажите параметр ``q`` для получение всех записей без фильтрации.
``equipment_type_id`` | int    | Выполняет поиск по ID типа оборудования.
``serial_number`` | string | Выполняет поиск по серийному номеру оборудования.
``desc`` | string | Выполняет поиск по примечанию/комментарию к оборудованию.


Пример запроса:<br>
```GET: /api/equipment?q```

Ответ:<br>
```
{
    "equipments": [
        {
            "id": 2,
            "equipment_type": {
                "id": 1,
                "name": "TP-Link TL-WR74",
                "mask": "XXAAAAAXAA"
            },
            "serial_number": "34NITRO6NK",
            "desc": "Необычный роутер",
            "created_at": "2024-07-03T17:45:07.000000Z",
            "updated_at": "2024-07-03T17:48:06.000000Z"
        },
        {
            "id": 3,
            "equipment_type": {
                "id": 1,
                "name": "TP-Link TL-WR74",
                "mask": "XXAAAAAXAA"
            },
            "serial_number": "30NITRO5NZ",
            "desc": "foo",
            "created_at": "2024-07-03T17:45:07.000000Z",
            "updated_at": "2024-07-03T17:45:07.000000Z"
        },
        {
            "id": 4,
            "equipment_type": {
                "id": 1,
                "name": "TP-Link TL-WR74",
                "mask": "XXAAAAAXAA"
            },
            "serial_number": "31NITRO5NZ",
            "desc": "Обычный роутер",
            "created_at": "2024-07-03T17:48:12.000000Z",
            "updated_at": "2024-07-03T17:48:12.000000Z"
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/equipment?page=1",
        "last": "http://localhost:8000/api/equipment?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8000/api/equipment?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://localhost:8000/api/equipment",
        "per_page": 20,
        "to": 3,
        "total": 3
    }
}
```


### GET: /api/equipment/{id}
Запрос данных оборудования по ID

Пример запроса:<br>
```GET: /api/equipment/1```

Ответ:<br>
```
{
    "equipment": {
        "id": 1,
        "equipment_type": {
            "id": 1,
            "name": "TP-Link TL-WR74",
            "mask": "XXAAAAAXAA"
        },
        "serial_number": "34NITRO5NX",
        "desc": "Роутер в доме напротив башни",
        "created_at": "2024-07-03T14:51:48.000000Z",
        "updated_at": "2024-07-03T14:51:51.000000Z"
    }
}
```

### POST: /api/equipment
Создание новой(ых) записи(ей). Принимает массив из объектов, которые требуется создать. При невозможности создать объект, просто пропускает его, продолжая создавать другие.


Пример запроса:<br>
```POST: /api/equipment```
```
{
    "equipments": [
        {
                "equipment_type_id": 1,
                "serial_number": "26NITRO6NK",
                "desc": "Обычный роутер"
        },
        {
                "equipment_type_id": 1,
                "serial_number": "31NITRO5NZ",
                "desc": "Обычный роутер"
        },
        {
                "equipment_type_id": 1,
                "serial_number": "30NITRO5NZ",
                "desc": "foo"
        }
    ]
}
```
Ответ:<br>
```
{
    "errors": [
        {
            "serial_number": [
                "The (equipment_type_id, serial_number) has already been taken."
            ]
        }
    ],
    "success": {
        "1": {
            "equipment_type_id": 1,
            "serial_number": "39NITRO5NZ",
            "desc": "Обычный роутер",
            "updated_at": "2024-07-03T17:52:32.000000Z",
            "created_at": "2024-07-03T17:52:32.000000Z",
            "id": 7
        },
        "2": {
            "equipment_type_id": 1,
            "serial_number": "38NITRO5NZ",
            "desc": "foo",
            "updated_at": "2024-07-03T17:52:32.000000Z",
            "created_at": "2024-07-03T17:52:32.000000Z",
            "id": 8
        }
    }
}
```
### PUT: /api/equipment/{id}
Редактирование записи по id.

Пример запроса:<br>
```PUT: /api/equipment/1```
```
{
    "equipment_type_id": 1,
    "serial_number": "34NITRO6NK",
    "desc": "Необычный роутер"
}
```
Ответ:<br>
```
{
    "id": 2,
    "equipment_type_id": 1,
    "serial_number": "34NITRO6NK",
    "desc": "Необычный роутер",
    "deleted_at": null,
    "created_at": "2024-07-03T17:45:07.000000Z",
    "updated_at": "2024-07-03T17:48:06.000000Z",
    "equipment_type": {
        "id": 1,
        "name": "TP-Link TL-WR74",
        "mask": "XXAAAAAXAA"
    }
}
```
### DELETE: /api/equipment/{id}
Удаление записи (мягкое удаление).

Пример запроса:<br>
```DELETE: /api/equipment/1```

Ответ:<br>
```
{
    "success": "Deleted"
}
```

### GET: /api/equipment-type
Вывод пагинированного списка типов оборудования с возможностью поиска путем указания query параметров советующим ключам объекта, либо указанием параметра q.

Query Parameter   | Type   | Description
----------------- |--------| ------------------------------------------------------------------
``q``        | string | Укажите параметр ``q`` для получение всех записей без фильтрации.
``name`` | string | Выполняет поиск по имени типа оборудования.
``mask`` | string | Выполняет поиск по маске оборудования.


Пример запроса:<br>
```GET: /api/equipment-type?q```

Ответ:<br>
```
{
    "equipmentTypes": [
        {
            "id": 1,
            "name": "TP-Link TL-WR74",
            "mask": "XXAAAAAXAA"
        },
        {
            "id": 2,
            "name": "D-Link DIR-300",
            "mask": "NXXAAXZXaa"
        },
        {
            "id": 3,
            "name": "D-Link DIR-300 E",
            "mask": "NAAAAXZXXX"
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/equipment-type?page=1",
        "last": "http://localhost:8000/api/equipment-type?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8000/api/equipment-type?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://localhost:8000/api/equipment-type",
        "per_page": 20,
        "to": 3,
        "total": 3
    }
}
```

## Улучшения, которые можно было бы сделать
- Добавить версию API (/api/v1/method)
