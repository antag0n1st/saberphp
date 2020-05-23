<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(dirname(__FILE__)) . DS);

include_once 'config.php';
include_once BASE_DIR.'global_data.php';
CACHING ? include_once BASE_DIR.'config/caching.php' : null;
include_once BASE_DIR.'lib/execution.php';
(HOST_ID != 0) ? Execution::startExecution() : null;
include_once BASE_DIR.'config/std_include.php';
Load::all_plugins();