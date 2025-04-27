<?php
define('APP_NAME', 'Task Manager - MOJ');
define('DEBUG_MODE', False);

require_once 'conninfo.php';

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}
?>