<?php

$cacheHost      = getenv('CACHE_HOST')  ?: 'localhost';
$cachePort      = getenv('CACHE_PORT')  ?: '6379';
$cachePassword  = getenv('CACHE_PASS')  ?: '';

return [
    '*' => [
        'hostname' => $cacheHost,
        'port'     => $cachePort,
        'password' => $cachePassword,
        'database' => 0,
        'timeout'  => null,
    ],
];
