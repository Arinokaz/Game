## Тестовое задание

#### Этапы развертывания:
1. docker-compose build
2. docker-compose up -d
3. заходим в php контейнер 'docker exec -it php-game bash'
4. cd game/backend
5. composer install

Команда для выполнения миграций: `php migrations.php`

Команда для выполнения консольных `команд: php console.php`

Команда для выполнения тестов: `./vendor/bin/phpunit`

---

##### FrontEnd
url: http://localhost:8080

login: Tester
password: 0000

Для разрботки:
1. заходим в php контейнер 'docker exec -it php-game bash'
2. cd game/frontend
3. npm run serve
4. url: http://localhost:8085

##### Adminer
url: http://localhost:8088

login: root
password: 123456

##### Краткое описание приложения:
Пользователь может залогинется и начать играть, при нажатии на кнопку "Играть", он получает 1 из 3 призов (Деньги, Балы, Предмет). По мимо забрать или отказаться, у денег есть функция: конвертации в балы денежный выграш.
