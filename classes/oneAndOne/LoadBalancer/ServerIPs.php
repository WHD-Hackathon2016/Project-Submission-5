<?php

namespace oneAndOne\LoadBalancer;

class ServerIPs extends \oneAndOne\Element
{
	public function __construct($data)
	{print_r($data);exit;
		staitc::$segment = '/load_balancers/' . $id . '/server_ips';
		parent::__construct($data);
	}
}