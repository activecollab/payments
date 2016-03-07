<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

defined('BASE_PATH') || define('BASE_PATH', realpath(__DIR__));
date_default_timezone_set('GMT');

if (is_file(dirname(__DIR__) . '/vendor/autoload.php')) {
    require dirname(__DIR__) . '/vendor/autoload.php';
}
require __DIR__.'/src/TestCase.php';
