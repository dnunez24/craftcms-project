<?php

$appDir = getenv('PLATFORM_APP_DIR');
$appName = getenv('PLATFORM_APPLICATION_NAME');
$docRoot = getenv('PLATFORM_DOCUMENT_ROOT');
$entropy = getenv('PLATFORM_PROJECT_ENTROPY');
$environment = getenv('PLATFORM_ENVIRONMENT');
$relationships = getenv('PLATFORM_RELATIONSHIPS');
$routesEncoded = getenv('PLATFORM_ROUTES');

$routes = json_decode(base64_decode($routesEncoded), true);
$relationships = json_decode(base64_decode($relationships), true);
$databaseArray = $relationships['database'];
$redisArray = $relationships['redis'];

foreach ($redisArray as $endpoint) {
    if (strpos($endpoint['host'], 'session') === false) {
        $cacheHost = $endpoint['host'];
        $cachePort = $endpoint['port'];
        continue;
    }

    $sessionHost = $endpoint['host'];
    $sessionPort = $endpoint['port'];
}

foreach ($databaseArray as $endpoint) {
    if (empty($endpoint['query']['is_master'])) {
        continue;
    }

    $dbName = $endpoint['path'];
    $dbHost = $endpoint['host'];
    $dbPassword = $endpoint['password'];
    $dbUser = $endpoint['username'];
    $dbPort = $endpoint['port'];
}

foreach ($routes as $url => $route) {
    if ($route['type'] === 'upstream' && $route['upstream'] === $appName) {
        $siteUrl =  $url;
    }
}

$overrideSession = "tcp://{$sessionHost}:{$sessionPort}";

if ($environment !== 'master') {
    $devMode = true;
}

switch ($environment) {
    case 'master':
        $craftEnv = 'production';
        break;
    case 'staging':
        $craftEnv = 'staging';
        break;
    default:
        $craftEnv = 'development';
        break;
};

$craftDir = $appDir.'/craft';
$vendorDir = $appDir.'/vendor';

# Craft path variables
putenv("CRAFT_BASE_PATH=$craftDir/");
putenv("CRAFT_APP_PATH=$vendorDir/craftcms/cms/src/");
putenv("CRAFT_FRAMEWORK_PATH=$vendorDir/yiisoft/yii/framework/");
putenv("CRAFT_CONFIG_PATH=$craftDir/config/");
putenv("CRAFT_PLUGINS_PATH=$craftDir/plugins/");
putenv("CRAFT_STORAGE_PATH=$craftDir/storage/");
putenv("CRAFT_TEMPLATES_PATH=$craftDir/templates/");
putenv("CRAFT_TRANSLATIONS_PATH=$craftDir/translations/");
putenv("CRAFT_VENDOR_PATH=$vendorDir/");

# Craft config variables
putenv("CRAFT_DEV_MODE=$devMode");
putenv("CRAFT_ENVIRONMENT=$craftEnv");
putenv("CRAFT_OVERRIDE_SESSION=$overrideSession");
putenv("CRAFT_SITE_URL=$siteUrl");
putenv("CRAFT_VALIDATION_KEY=$entropy");

# Cache variables
putenv("CACHE_HOST=$cacheHost");
putenv("CACHE_PORT=$cachePort");

# Database variables
putenv("MYSQL_DATABASE=$dbName");
putenv("MYSQL_HOST=$dbHost");
putenv("MYSQL_PASSWORD=$dbPassword");
putenv("MYSQL_PORT=$dbPort");
putenv("MYSQL_USER=$dbUser");
