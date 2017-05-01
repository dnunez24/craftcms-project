<?php

return array(
    '*' => array(
        'hostname' => getenv('CACHE_HOST') ?: 'localhost',
        'port'     => getenv('CACHE_PORT') ?: '6379',
        'password' => getenv('CACHE_PASS') ?: '',
        'database' => 0,
        'timeout'  => null,
    ),
);
