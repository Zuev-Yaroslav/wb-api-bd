<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Инструкция развёртывния проекта


- Создать пустую папку для клонирования проекта
- Прописать в терминале в той же папке `git clone https://github.com/Zuev-Yaroslav/wb-api-bd.git` (убедитесь, что на вашем ПК установлен GIT)
- Создать дубликат файла .env.example и переименовать на .env
- В .env можете поменять в DB_CONNECTION название субд (sqlite, mysql).

- Прописать в терминале:
```` bash
composer update
php artisan key:generate
php artisan migrate
````
- Записать в бд данные
```` bash
php artisan go
````

ДОСТУП К БД: https://isp8.eurobyte.ru/vh6357361/phpmyadmin
````
DB_DATABASE=vh6357361_wb_api
DB_USERNAME=vh6357361_tester
DB_PASSWORD=zJ9tA3zN1l
````

ТАБЛИЦЫ

- incomes - доходы
- orders - заказы
- sales - продажи
- stocks - склады
