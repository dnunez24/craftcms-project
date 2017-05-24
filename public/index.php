<?php

/**
 * Craft web bootstrap file
 */

// Project root path
$root = dirname(__DIR__);
$craftPath = realpath($root.'/craft');

// Craft
define('CRAFT_BASE_PATH', $craftPath.'/');
define('CRAFT_VENDOR_PATH', realpath($root.'/vendor').'/');
define('CRAFT_APP_PATH', realpath(CRAFT_VENDOR_PATH.'craftcms/cms/src').'/');
define('CRAFT_FRAMEWORK_PATH', realpath(CRAFT_VENDOR_PATH.'yiisoft/yii/framework').'/');

require realpath(CRAFT_VENDOR_PATH.'autoload.php');

$index = realpath(CRAFT_APP_PATH.'index.php');

if (!is_file($index)) {
    if (function_exists('http_response_code')) {
        http_response_code(503);
    }

    $msg = 'Could not find your craft/ folder. ';
    $msg .= 'Please ensure that <strong><code>$craftRoot</code></strong> is set correctly in '.__FILE__;
    exit($msg);
}

require_once $index;
