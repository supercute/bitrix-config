<?php

// Конфиг для тестов репозитория без env

return [
    'app' => [
        'name' => 'Bitrix Site',
        'env' => 'testing',
        'debug' => false,
    ],
    'example_option' => "example_value",
    "example_optgroup" => [
        "foo" => "bar",
    ],
];
