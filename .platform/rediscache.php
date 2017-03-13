<?php

$relationships = json_decode(base64_decode(getenv('PLATFORM_RELATIONSHIPS')), true);
$cache = $relationships['cache'][0];
$cacheHost = $cache['host'];
$cachePort = $cache['port'];

return [
    '*' => [
        'hostname' => $cacheHost,
        'port'     => $cachePort,
        'password' => '',
        'database' => 0,
        'timeout'  => null,
    ],
];
