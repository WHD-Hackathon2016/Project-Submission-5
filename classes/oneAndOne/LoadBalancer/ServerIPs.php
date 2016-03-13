<?php

namespace oneAndOne\LoadBalancer;

class ServerIPs extends \oneAndOne\Element
{
	public function __construct($data)
	{
		parent::__construct($data);
	}

    public static function get($id = null)
    {
        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
        $url= \AppConfig::getData('API')['url']. '/load_balancers/' . $id . '/server_ips';
        $result = $curl->get($url);

		return static::createObject($result);
	}

	public function post($id, $postparams)
	{
        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
        $url= \AppConfig::getData('API')['url']. '/load_balancers/' . $id . '/server_ips';
        $result = $curl->post($url, $postparams);

		return $result;
	}
}