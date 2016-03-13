<?php

namespace transporter;

interface ITransporter
{
	public function __construct($credentials = null);

	public function get($url);

	public function post($url,$data);
}
