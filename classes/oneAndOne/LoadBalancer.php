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
    static $segment = "/load_balancers";

	public function checkLoad($id)
	{
		$result = parent::get($id);

		if (isset($result->content->server_ips) && is_array($result->content->server_ips))
		{
			$serverclass = new \oneAndOne\Server;

			// Loop all servers in the balancer
			foreach ($result->content->server_ips as $server)
			{
				// Check if we have to optimize the server
				$newserver = $serverclass->optimize($server->id);

				// If we have a server object here, the optimize method cloned the server, so let's add it to the balancer
				if ($newserver)
				{
					$this->addServer($id, $newserver);
				}
			}
		}
	}

	public function addServer($loader_id, $serverId)
	{
		// Load the IP


		$servers = new \oneAndOne\LoadBalancer\ServerIPs($loader_id);

		$newserver = new \stdClass;
		$newserver->server_ips = array($serverId);

		$result = $servers->post(json_encode($newserver));

		print_r($result);
    }
}
