<?php
/**
 * config.php — единый конфиг для Битрикса
 *
 * Доступ: config('app.debug'), config('db.host'), config('smtp.host')
 *
 * Внутри можно использовать env() — значения подтянутся из .env
 */

return [
    'app' => [
        'name' => env('APP_NAME'),
        'env' => env('APP_ENV'),
    ],
    'example_option' => "example_value",
    "example_optgroup" => [
        "foo" => "bar",
    ]
];
