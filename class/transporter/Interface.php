<?php

namespace transporter;

interface AppInterface
{
	public function __construct($credentials = null);

	public function get($url);

	public function post($url);
}
