<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */

return [
    'driver'        => getenv('DB_DRIVER') ?: 'mysql',
    'server'        => getenv('DB_SERVER') ?: 'localhost',
    'user'          => getenv('DB_USER') ?: 'craftcms',
    'password'      => getenv('DB_PASSWORD') ?: 'craftcms',
    'database'      => getenv('DB_DATABASE') ?: 'craftcms',
    'schema'        => getenv('DB_SCHEMA') ?: 'public',
    'tablePrefix'   => getenv('DB_TABLE_PREFIX') ?: '',
    'port'          => getenv('MYSQL_PORT') ?: '3306',
];
