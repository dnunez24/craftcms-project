<?php

$devMode                    = $environment === 'dev';
$cpTrigger                  = getenv('CRAFT_CP_TRIGGER')        ?: 'admin';
$environment                = getenv('CRAFT_ENVIRONMENT')       ?: 'production';
$overrideSessionLocation    = getenv('CRAFT_OVERRIDE_SESSION')  ?: 'auto';
$validationKey              = getenv('CRAFT_VALIDATION_KEY')    ?: null;

return [
    '*' => [
        'allowAutoUpdates'              => false,
        'appId'                         => 'craftcms',
        'cacheMethod'                   => 'redis',
        'cpTrigger'                     => $cpTrigger,
        'devMode'                       => $devMode,
        'enableCsrfProtection'          => true,
        'errorTemplatePrefix'           => '_errors/',
        'omitScriptNameInUrls'          => true,
        'overridePhpSessionLocation'    => $overrideSessionLocation,
        'preventUserEnumeration'        => true,
        'usePathInfo'                   => true,
        'validationKey'                 => $validationKey,
    ]
];
