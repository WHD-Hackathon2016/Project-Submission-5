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

	echo "Power up the system\n";
	echo "This may take some seconds...\n";

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
	}

	$loadbalancer = \oneAndOne\LoadBalancer::get($params['loader']);

	if (!$loadbalancer->id)
	{
		throw new Exception('Invalid load balancer given');
	}

	$date = new DateTime;

	$filename = BASE_DIR . '/logs/' . $params['loader'];

	$canClone = true;

	if (file_exists($filename))
	{
		$content = file_get_contents($filename);

		$last_clone = date_create_from_format('Y-m-d H:i:s', $content);

		if ($last_clone)
		{
			$diff = $last_clone->diff($date);

			$canClone = (int) $diff->format('s') > 360;
		}
	}

	$iscloned = false;

	if ($canClone)
	{
			$iscloned = $loadbalancer->checkLoad();
	}
	else
	{
		echo "I already cloned within the last 6 minutes...Nothing to do\n";
	}

	if ($iscloned)
	{
		file_put_contents($filename, $date->format('Y-m-d H:i:s'));
	}

	echo 'Closing...';

} catch (Exception $ex) {
	echo 'A wild error appears: ' . $ex->getMessage();
}
