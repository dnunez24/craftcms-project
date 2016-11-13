<?php

return array(
    '*' => array(
    	'port'     => isset($_ENV['REDIS_PORT']) ? $_ENV['REDIS_PORT'] : '6379',
    	'password' => isset($_ENV['REDIS_PASS']) ? $_ENV['REDIS_PASS'] : '',
    	'database' => 0,
    	'timeout'  => null,
    ),
    'dev' => array(
    	'hostname' => 'cache.' . $_ENV['COMPOSE_PROJECT_NAME'] . '.dev',
    ),
);
