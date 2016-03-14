<?php

// Make sure we're being called from the command line, not a web interface
if (array_key_exists('REQUEST_METHOD', $_SERVER)) die;

error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 1);

define('BASE_DIR', __DIR__);

try {

	include_once 'autoload.php';

	AppConfig::readFile();

	if ($argc == 1)
	{
		throw new Exception('No load balancer given');
	}

	$parameters = $argv;

	// Remove the file path
	array_shift($parameters);

	$params = array();

	foreach ($parameters as $param)
	{
		$temp = explode('=', $param);

		if (isset($temp[0]) && isset($temp[1]))
		{
			$params[$temp[0]] = $temp[1];
		}
	}

	if (!isset($params['loader']))
	{
		throw new Exception('No load balancer given');

		return;
	}

	$loadbalancer = \oneAndOne\LoadBalancer::get($params['loader']);

	if (!$loadbalancer->id)
	{
		throw new Exception('Invalid load balancer given');
	}

	$loadbalancer->checkLoad();

	echo '[DONE]';

} catch (Exception $ex) {
	echo 'A wild error appears: ' . $ex->getMessage();
}
