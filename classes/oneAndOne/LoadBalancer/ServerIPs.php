<?php

namespace oneAndOne\LoadBalancer;

class ServerIPs extends \oneAndOne\Element
{
	public function __construct($id)
	{
		staitc::$segment = '/load_balancers/' . $id . '/server_ips';
	}
}