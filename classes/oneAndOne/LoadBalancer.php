<?php

namespace oneAndOne;

/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 13:52
 */
class LoadBalancer extends Element
{
    protected $segment = "/load_balancers";

	public function checkLoad($id)
	{
		$result = parent::get($id);

		if (isset($result['server_ips']) && is_array($result['server_ips']))
		{
			foreach ($result['server_ips'] as $server)
			{
				print_r($server);
			}
		}
	}
}