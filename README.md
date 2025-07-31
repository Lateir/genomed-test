# Genomed QR - Yii2 Проект

Веб-приложение на базе Yii2 Framework для создания QR-кодов с системой коротких URL.

## Особенности

- 🔗 Создание коротких URL
- 📱 Генерация QR-кодов
- 📊 Отслеживание переходов по ссылкам
- 🐳 Docker-контейнеризация для разработки
- 🧪 Тестирование с Codeception и PHPUnit


## Требования

- PHP 7.4+
- Composer
- MariaDB/MySQL

Либо

- Docker
- Docker Compose

## Установка и запуск

### Локальная разработка с Docker

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/Lateir/genomed-test.git
   cd genomed-qr
   ```

2. Запустите Docker-контейнеры:
   ```bash
   cd contrib
   docker compose up -d
   ```

3. Подключитесь к PHP-контейнеру:
   ```bash
   docker exec -it yii2-php bash
   ```

4. Установите зависимости Composer:
   ```bash
   composer install
   ```

5. Сгенерируйте ключ безопасности:
   ```bash
   php yii security/generate-key
   ```

6. Выполните миграции базы данных:
   ```bash
   php yii migrate
   ```

7. Приложение будет доступно по адресу: [http://localhost:8080](http://localhost:8080)

## Конфигурация базы данных

Приложение использует MariaDB. Параметры подключения в Docker:
- **База данных:** yii2app
- **Пользователь:** yii2user
- **Пароль:** secret
- **Хост:** db
- **Порт:** 3306

## Тестирование

Проект использует Codeception для тестирования. 

```bash
# Сборка всех тестов
php vendor/bin/codecept build

# Запуск всех тестов
php vendor/bin/codecept run

```