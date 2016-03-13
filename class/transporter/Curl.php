<?php

namespace transporter;

class Curl extends \transporter\Transporter
{
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
		$ch = \curl_init();

		$options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);

		$headers['x-token'] = $this->xtoken;

		$finishedHeaders = array();

		foreach ($headers as $key => $header)
		{
			$finishedHeaders[] = $key . ':' . $header;
		}

		$options[CURLOPT_HTTPHEADER] = $headers;

		curl_setopt_array($ch, $options);

		$content = curl_exec($ch);

		curl_close($ch);

		print_r($content);

	}
}