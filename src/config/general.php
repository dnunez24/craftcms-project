<?php

return [
    '*' => [
        'cacheMethod'           => 'redis',
        'cpTrigger'             => 'admin',
        'enableCsrfProtection'  => true,
        'omitScriptNameInUrls'  => true,
        'siteUrl'               => getenv('BASE_URL') ?: 'http://dev.craftcms.com',
        'usePathInfo'           => true,
    ],
    'dev' => [
        'devMode'                       => true,
        'useCompressedJs'               => false,
        'overridePhpSessionLocation'    => getenv('SESSION_HOST') ?: '',
    ],
];
