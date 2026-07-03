# bitrix-config
Библиотека для работы с конфигурацией в 1C-Битрикс с поддержкой `.env`.

<a href="LICENSE"><img src="https://img.shields.io/badge/license-BSD%203--Clause-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://github.com/supercute/bitrix-config/releases"><img src="https://img.shields.io/github/release/supercute/bitrix-config.svg?style=flat-square" alt="Latest Version"></img></a>

## Установка

```bash
composer require supercute/bitrix-config
```

## Настройка

Создайте файлы `.env` и `config.php` в директории:

```
<root>/local/php_interface/
```

При необходимости их можно разместить в любом другом месте, указав путь при инициализации.

Файл `config.php` должен возвращать массив конфигурации. Для получения значений из окружения можно использовать функцию `env()`:

```php
<?php

return [
    'app' => [
        'name' => env('APP_NAME'),
        'env'  => env('APP_ENV', 'production'),
    ],
];
```

## Инициализация

Подключите библиотеку, например, в `init.php`:

```php
use Supercute\BitrixConfig\Config;

Config::init($_SERVER['DOCUMENT_ROOT']);
```

По умолчанию библиотека ищет файлы конфигурации относительно переданного пути.

Если файл `.env` отсутствует, значения будут использоваться из системных переменных окружения.

## Использование

Получение значения из конфигурации:

```php
config('app.name');
```

Получение переменной окружения:

```php
env('APP_NAME');
```
