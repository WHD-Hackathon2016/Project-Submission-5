<?php

// Make sure we're being called from the command line, not a web interface
if (array_key_exists('REQUEST_METHOD', $_SERVER)) die;

error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 1);

print_r($argv);