<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */

return array(
    '*' => array(
    	'database'      => isset($_ENV['MYSQL_DATABASE']) ? $_ENV['MYSQL_DATABASE'] : 'craftcms',
        'port'          => isset($_ENV['MYSQL_PORT'])     ? $_ENV['MYSQL_PORT']     : '3306',
    	'user'          => isset($_ENV['MYSQL_USER'])     ? $_ENV['MYSQL_USER']     : 'craftcms',
    	'password'      => isset($_ENV['MYSQL_PASSWORD']) ? $_ENV['MYSQL_PASSWORD'] : 'craftcms',
    	'tablePrefix'   => '',
        'charset'       => 'utf8',
        'collation'     => 'utf8_unicode_ci',
    ),
    'dev' => array(
        'server' => 'db.' . $_ENV['COMPOSE_PROJECT_NAME'] . '.dev',
    ),
);
