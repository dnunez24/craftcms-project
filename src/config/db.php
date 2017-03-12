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
    'database'      => getenv('DB_DATABASE') ?: 'craftcms',
    'user'          => getenv('DB_USER') ?: 'craftcms',
    'password'      => getenv('DB_PASSWORD') ?: 'craftcms',
    'schema'        => getenv('DB_SCHEMA') ?: 'public',
    'tablePrefix'   => getenv('DB_TABLE_PREFIX') ?: '',
    'port'          => getenv('DB_PORT') ?: '3306',
    'initSQLs' => ["SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';"],
];
