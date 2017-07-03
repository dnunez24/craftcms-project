<?php

$appDir                 = getenv('PLATFORM_APP_DIR');
$appName                = getenv('PLATFORM_APPLICATION_NAME');
$docRoot                = getenv('PLATFORM_DOCUMENT_ROOT');
$entropy                = getenv('PLATFORM_PROJECT_ENTROPY');
$environment            = getenv('PLATFORM_ENVIRONMENT');
$relationshipsEncoded   = getenv('PLATFORM_RELATIONSHIPS');
$routesEncoded          = getenv('PLATFORM_ROUTES');

// Decode relationships and routes
$routes = json_decode(base64_decode($routesEncoded), true);
$relationships = json_decode(base64_decode($relationshipsEncoded), true);

// Get services from relationships
$db = $relationships['db'];
$cache = $relationships['cache'];
$session = $relationships['session'];

// Get service properties
$cacheHost   = $cache[0]['host'];
$cachePort   = $cache[0]['port'];
$dbName      = $db[0]['path'];
$dbHost      = $db[0]['host'];
$dbPassword  = $db[0]['password'];
$dbUser      = $db[0]['username'];
$dbPort      = $db[0]['port'];
$sessionHost = $session[0]['host'];
$sessionPort = $session[0]['port'];

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
