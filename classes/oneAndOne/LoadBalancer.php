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

	public function checkLoad()
	{
		if (isset($this->data->server_ips) && is_array($this->data->server_ips))
		{
			// Loop all servers in the balancer
			foreach ($this->data->server_ips as $server)
			{
				$serverclass = \oneAndOne\Server::get($server->id);

				// Check if we have to optimize the server
				$newserver = $serverclass->optimize();

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
