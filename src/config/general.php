<?php

return [
    '*' => [
        'cacheMethod'                   => 'redis',
        'cpTrigger'                     => 'admin',
        'enableCsrfProtection'          => true,
        'omitScriptNameInUrls'          => true,
        'siteUrl'                       => getenv('BASE_URL') ?: 'http://dev.craftcms.com',
        'usePathInfo'                   => true,
        'overridePhpSessionLocation'    => getenv('SESSION_LOCATION'),
    ],
    'dev' => [
        'devMode'                       => true,
        'useCompressedJs'               => false,
    ],
];
