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
		$hour = date('H');

		if ($hour < 12)
		{
			echo "Good Morning,\n";
		}
		elseif ($hour < 18)
		{
			echo "Good Afternoon,\n";
		}
		else
		{
			echo "Good Evening,\n";
		}

		echo "I found the following load balancer: $this->name\n";

		echo "Now I search for existing servers...\n";

		if (isset($this->data->server_ips) && is_array($this->data->server_ips))
		{
			// Loop all servers in the balancer
			foreach ($this->data->server_ips as $server)
			{
                // we have the ip of the server, so we have to get the element to get the real id of the server
                $serverIp = ServerIP::get($server->id);
                $serverId = $serverIp->assigned_to->id;
				$serverclass = \oneAndOne\Server::get($serverId);

				echo "I found the following server: " . $serverclass->name . "\n";
				echo "I try to optimize it!\n";

				// Check if we have to optimize the server
				$newserverId = $serverclass->optimize();

				// If we have a server object here, the optimize method cloned the server, so let's add it to the balancer
				if ($newserverId)
				{
					echo "Try to add the new server to the current load balancer\n";

					$this->addServer($newserverId);
				}
				else
				{
					echo "The server state is OK, continue\n";
				}
			}
		}
		else
		{
			echo "No servers found!\n";
		}
	}

	public function addServer($serverId)
	{
		$newserver = new \stdClass;
		$newserver->server_ips = array($serverId);

        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
        $url= \AppConfig::getData('API')['url']. '/load_balancers/' . $this->data->id . '/server_ips';
        $result = $curl->post($url, json_encode($newserver));
    }
}
