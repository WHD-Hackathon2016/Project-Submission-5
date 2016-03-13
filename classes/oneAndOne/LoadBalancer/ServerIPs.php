<?php

namespace oneAndOne\LoadBalancer;

class ServerIPs extends \oneAndOne\Element
{
	public function __construct($id)
	{
		$this->segment = 'load_balancers/' . $id . '/server_ips';
	}

	public function add($postparams)
	{
		return parent::post($postparams);
	}
}