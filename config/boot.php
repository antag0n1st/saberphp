<?php

include_once 'config/config.php';
include_once BASE_DIR.'lib/execution.php';
(HOST_ID != 0) ? Execution::startExecution() : null;
include_once BASE_DIR.'config/std_include.php';
Load::all_plugins();

?>