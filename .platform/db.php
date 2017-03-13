<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */

$relationshipsEncoded = getenv('PLATFORM_RELATIONSHIPS');

if ($relationshipsEncoded) {
    $relationships = json_decode(base64_decode($relationshipsEncoded), true);
    $database = $relationships['db'][0];
    $dbScheme = $database['scheme'];
    $dbName = $database['path'];
    $dbHost = $database['host'];
    $dbPort = $database['port'];
    $dbUser = $database['username'];
    $dbPassword = $database['password'];
}

return [
    'driver'        => $dbScheme,
    'server'        => $dbHost,
    'port'          => $dbPort,
    'database'      => $dbName,
    'user'          => $dbUser,
    'password'      => $dbPassword,
    'tablePrefix'   => '',
    'initSQLs' => ["SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';"],
];
