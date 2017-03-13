<?php

$relationshipsEncoded = getenv('PLATFORM_RELATIONSHIPS');
$routesEncoded = getenv('PLATFORM_ROUTES');
$applicationName = getenv('PLATFORM_APPLICATION_NAME');

if ($relationshipsEncoded) {
    $relationships = json_decode(base64_decode($relationshipsEncoded), true);
    $session = $relationships['session'][0];
    $sessionHost = $session['host'];
    $sessionPort = $session['port'];
    $sessionLocation = "tcp://$sessionHost:$sessionPort";
}

$config = [];

$config['*'] = [
    'appId'                         => 'craftcms',
    'cacheMethod'                   => 'redis',
    'cpTrigger'                     => 'admin',
    'enableCsrfProtection'          => true,
    'omitScriptNameInUrls'          => true,
    'usePathInfo'                   => true,
    'overridePhpSessionLocation'    => $sessionLocation,
    'allowAutoUpdates'              => false,
    'devMode'                       => getenv('CRAFT_ENVIRONMENT') === 'dev',
    'useCompressedJs'               => getenv('CRAFT_ENVIRONMENT') !== 'dev',
];

if ($routesEncoded) {
    $routes = json_decode(base64_decode($routesEncoded), true);

    foreach ($routes as $url => $route) {
        if ($route['type'] === 'upstream' && $route['upstream'] === $applicationName) {
            $host = parse_url($url, PHP_URL_HOST);
            $config[$host] = ['siteUrl' => $url];
        }
    }
}

return $config;
