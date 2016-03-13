<?php

namespace transporter;

use classes\AppConfig;
use response\Json;

class Curl extends \transporter\Transporter
{
	protected $certificate;

	public function __construct($xtoken = null)
	{
		parent::__construct($xtoken);

		$this->certificate = BASE_DIR . '/config/cacert.pem';
	}

	public function get($url)
	{
		return $this->request($url, 'GET');
	}

	public function post($url)
	{
		return $this->request($url, 'POST');
	}

	public function request($url, $method, $options = array(), $headers = array())
	{
		$ch = curl_init();

		$options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);

		$options[CURLOPT_URL] = (string) $url;

		$headers['x-token'] = $this->xtoken;

		$finishedHeaders = array();

		foreach ($headers as $key => $header)
		{
			$finishedHeaders[] = $key . ': ' . $header;
		}

		$options[CURLOPT_HTTPHEADER] = $finishedHeaders;
		$options[CURLOPT_RETURNTRANSFER] = true;

		if (false && $this->certificate)
		{
			$options[CURLOPT_CAINFO] = $this->certificate;
		}
		else
		{
			$options[CURLOPT_SSL_VERIFYPEER] = false;
		}

		curl_setopt_array($ch, $options);

		$content = curl_exec($ch);

		return new \response\JSON($content);
	}
}