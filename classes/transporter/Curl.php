<?php
/**
 * @package    1&1 Server monitoring
 *
 * @author     Francisco Aramayo Martinez <faramayo@arsys.es>
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 *
 * @license    GNU General Public License version 3 or later; see LICENSE
 */

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

	public function post($url, $data = null)
	{
		return $this->request($url, 'POST', $data);
	}

	public function delete($url, $data = null)
	{
		return $this->request($url, 'DELETE', $data);
	}

	public function request($url, $method, $data = null, $options = array(), $headers = array())
	{
		if (DEBUG)
		{
			echo "Calling: $url\n";
		}

		$ch = curl_init();

		$options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);

		$options[CURLOPT_URL] = (string) $url;

		if (isset($data))
		{
			// If the data is a scalar value simply add it to the cURL post fields.
			if (is_scalar($data) || (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'multipart/form-data') === 0))
			{
				$options[CURLOPT_POSTFIELDS] = $data;
			}
			// Otherwise we need to encode the value first.
			else
			{
				$options[CURLOPT_POSTFIELDS] = http_build_query($data);
			}

			// Add the relevant headers.
			if (is_scalar($options[CURLOPT_POSTFIELDS]))
			{
				$headers['Content-Length'] = strlen($options[CURLOPT_POSTFIELDS]);
			}
		}

		if (!isset($headers['Content-Type']))
		{
			$headers['Content-Type'] = 'application/json';
		}

		$headers['x-token'] = $this->xtoken;

		$finishedHeaders = array();

		foreach ($headers as $key => $header)
		{
			$finishedHeaders[] = $key . ': ' . $header;
		}

		$options[CURLOPT_HTTPHEADER] = $finishedHeaders;
		$options[CURLOPT_RETURNTRANSFER] = true;

		if ($this->certificate)
		{
			$options[CURLOPT_CAINFO] = $this->certificate;
		}
		else
		{
			$options[CURLOPT_SSL_VERIFYPEER] = false;
		}

		curl_setopt_array($ch, $options);

		$content = curl_exec($ch);
		$errorno = curl_errno($ch);

		if ($content == false || $errorno > 0)
		{
			$error = curl_error($ch);

			throw new Exception($error, $errorno);
		}

		return new \response\JSON($content);
	}
}