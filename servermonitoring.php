<?php

// Make sure we're being called from the command line, not a web interface
if (array_key_exists('REQUEST_METHOD', $_SERVER)) die;

error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 1);

include_once 'autoload.php';

AppConfig::readFile();
$curl = new \transporter\Curl(AppConfig::getData('API')['token']);
$url= AppConfig::getData('API')['url'].'ping';
$curl->get($url);

print_r($argv);