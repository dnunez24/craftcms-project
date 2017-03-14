<?php

$environment = getenv('CRAFT_ENVIRONMENT');
$routesEncoded = getenv('PLATFORM_ROUTES');
$applicationName = getenv('PLATFORM_APPLICATION_NAME');
$entropy = getenv('PLATFORM_PROJECT_ENTROPY');

$config = [];

$config['*'] = [
    'allowAutoUpdates'              => false,
    'appId'                         => 'craftcms',
    'cacheMethod'                   => 'redis',
    'cpTrigger'                     => 'admin',
    'enableCsrfProtection'          => true,
    'errorTemplatePrefix'           => '_errors/',
    'omitScriptNameInUrls'          => true,
    'usePathInfo'                   => true,
    'overridePhpSessionLocation'    => true,
    'allowAutoUpdates'              => false,
    'devMode'                       => $environment === 'dev',
    'useCompressedJs'               => $environment !== 'dev',
    'validationKey'                 => $entropy,
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
