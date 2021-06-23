## Запуск Laravel
Запуск через консоль Ubuntu 20.04:

- Создать папку проекта, перейти в нее и установить Composer https://getcomposer.org/download/

- Выполнить команду:
```bash
git clone https://github.com/RuslanUI/library-api .
```
- Установить Sail:
```bash
composer require laravel/sail --dev
php artisan sail:install
```

- Установить все зависимости через Composer
```bash
composer install
```

- Запустить проекта из папки 
```bash
./vendor/bin/sail up
```

- Сайт будет доступен по ссылке http://localhost
- Выполнить миграции командой
```bash
php artisan migrate:refresh --seed
```

## Процесс создания переменных окружения и установке зависимостей

При запуске команды `./vendor/bin/sail up` генерируются переменные окружения (.env) и загружаются/подключаются зависимости из composer.json

## API

Получение списка всех книг / авторов
```
GET api/book
GET api/author
```

Получение списка всех книг с сортировкой по рейтингу / авторов с выводом всех книг
```
GET api/book?order={asc/desc}
GET api/author?all
```

Создание книги / автора
```
POST api/book BODY name=BookName, authorName=Author
POST api/author BODY authorName=Author
```

Обновление книги / автора
```
PUT api/book/{id}?name=NewNameBook&authorName=Author
PUT api/author/{id}?authorName=NewAuthor
```

Удаление книги / автора 
```
DELETE api/book/{id} 
DELETE api/author/{id}
```

Установка оценки книге / автору
```
POST api/rating BODY id=1, type=book, rating=5
POST api/rating BODY id=1, type=author, rating=5
```

Поиск книг / авторов
```
GET api/search/{Пушкин}
```