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
        $siteUrl = $url;
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

$initDir = $appDir.'/init';
$craftDir = $appDir.'/craft';
$vendorDir = $appDir.'/vendor';
$configDir = $craftDir.'/config';

# Copy config files from build init directory to read/write config directory
`cp -R $initDir/config/* $configDir/`;

function reconfigure($name, $confDir, $conf)
{
    $file = "$confDir/$name.php";
    $oldConf = include $file;

    echo "$name (old):\n";
    echo var_export($oldConf)."\n";

    $newConf = array_merge($oldConf, $conf);

    echo "$name (new):\n";
    echo var_export($newConf)."\n";

    $newFileContent = "<?php\n\nreturn " . var_export($newConf, true) . ";";
    file_put_contents($file, $newFileContent);
}

reconfigure('general', $configDir, [
    'appId' => $appName,
    'devMode' => $devMode,
    'overridePhpSessionLocation' => $overrideSession,
    'siteUrl' => $siteUrl,
    'validationKey' => $entropy,
]);

reconfigure('db', $configDir, [
    'database' => $dbName,
    'password' => $dbPassword,
    'port' => $dbPort,
    'server' => $dbHost,
    'user' => $dbUser,
]);

reconfigure('rediscache', $configDir, [
    'hostname' => $cacheHost,
    'port' => $cachePort,
]);
