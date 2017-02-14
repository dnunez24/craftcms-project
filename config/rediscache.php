<?php

return array(
    '*' => array(
    	'hostname' => getenv('REDIS_HOST') ?: 'localhost',
    	'port'     => getenv('REDIS_PORT') ?: '6379',
    	'password' => getenv('REDIS_PASS') ?: '',
    	'database' => 0,
    	'timeout'  => null,
    ),
);
