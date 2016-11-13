<?php

return array(
    '*' => array(
        'cacheMethod' => 'redis',
        'usePathInfo' => true,
        'omitScriptNameInUrls' => true,
    ),
    'dev' => array(
        'environmentVariables' => array(
            'baseUrl' => 'http://www.' . $_ENV['COMPOSE_PROJECT_NAME'] . '.dev',
        ),
        'devMode' => true,
        'useCompressedJs' => false,
        'overridePhpSessionLocation' => 'tcp://session.' . $_ENV['COMPOSE_PROJECT_NAME'] . '.dev:' . $_ENV['REDIS_PORT'],
    ),
);
