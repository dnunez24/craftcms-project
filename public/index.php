<?php

/**
 * Craft web bootstrap file
 */

// Project root path
$root = dirname(__DIR__);
$craftPath = $root.'/src';

// Craft
define('CRAFT_BASE_PATH', $craftPath.'/');
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH.'/vendor/');
define('CRAFT_APP_PATH', CRAFT_VENDOR_PATH.'/craftcms/cms/src/');

$index = $craftPath.'/vendor/craftcms/cms/src/index.php';

if (!is_file($index)) {
    if (function_exists('http_response_code')) {
        http_response_code(503);
    }

    $msg = 'Could not find your craft/ folder. ';
    $msg .= 'Please ensure that <strong><code>$craftRoot</code></strong> is set correctly in '.__FILE__;
    exit($msg);
}

require_once $index;
