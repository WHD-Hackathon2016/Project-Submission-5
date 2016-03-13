<?php

interface AppTransporterInterface
{
	public function __construct($credentials = null);

	public function get($url);

	public function post($url);
}
