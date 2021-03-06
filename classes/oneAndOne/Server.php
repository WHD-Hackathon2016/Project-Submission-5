<?php
/**
 * @package    1&1 Server monitoring
 *
 * @author     Francisco Aramayo Martinez <faramayo@arsys.es>
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 *
 * @license    GNU General Public License version 3 or later; see LICENSE
 */

namespace oneAndOne;

class Server extends Element
{
    static $segment = "/servers";

    public function optimize()
    {
		$monitoringId = $this->data->monitoring_policy->id;
        $monitoring = MonitoringPolicy::get($monitoringId);

        if ($this->checkThresholds($monitoring->thresholds))
		{
            // todo: we have to check if we must to clone the server
            $newServer = $this->cloneServer();

            // wait until the server has an ip
            $count = 0;
            $ip = null;

			if (!$newServer)
			{
				return false;
			}

            echo 'Waiting for the correct IP';

            do {
                $server = Server::get($newServer->id);

                if (isset($server->ips[0]->id)) {
                    $ip = $server->ips[0]->id;
                } else {
                    echo '.';
                }

                ++$count;

                sleep(5);
            } while (is_null($ip) && $count < 20);

            echo "\n";

            return $ip;
        }

        return false;
    }

    public function checkLowerLimits()
    {
        $monitoringId = $this->data->monitoring_policy->id;
        $monitoring = MonitoringPolicy::get($monitoringId);
        $cpuWarning = $monitoring->thresholds->cpu->warning->value;
        $ramWaning = $monitoring->thresholds->ram->warning->value;

        $monitoringCenter = MonitoringCenter::get($this->data->id);

        //at the moment we only check critical ram and cpu
        $resources = array(
            'ram' => $cpuWarning,
            'cpu' => $ramWaning);

        $result = false;

        foreach ($resources as $resource => $limit)
        {
            echo "Checking ".$resource." of " . $this->data->name . "\n";
            $result = $monitoringCenter->checkInactive($limit / 2, $resource);

            if (!$result)
            {
                break;
            }
        }
        if($result)
        {
            "Server is working fine!!\n\n";
        }
        return $result;
    }

    /**
 * @param $id
 * @return mixed
 * @throws \Exception
 */
    public function cloneServer()
    {
		echo "Cloning the server \"{$this->data->name}\"\n";

        //we check if serveris in correct status
        if($this->data->status->state === 'POWERED_ON' || $this->data->status->state === 'POWERED_OFF'){
            $url = \AppConfig::getData('API')['url'] . static::$segment . "/" . $this->data->id . "/clone";
            $postParams = "{\"name\": \"Server Cloned at ".date('Y-m-d H:i:s')."\"}";
            $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);

            $result = $curl->post($url, $postParams);

			return $this->createObject($result);
        }
		else
		{
			echo "Can't clone the server in actual state\n";
		}

		return false;
    }

	public function deleteServer()
	{
		$url = \AppConfig::getData('API')['url'] . static::$segment . "/" . $this->data->id;

		$curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
		$result = $curl->delete($url);

		return $this->createObject($result);
	}

    public function checkThresholds($thresholds)
    {
        $cpuCritical = $thresholds->cpu->critical->value;
        $ramCritical = $thresholds->ram->critical->value;
        //$diskCritical = $thresholds->disk->critical->value; //only works with agent installed

        /*print_r(array(
            $cpuCritical,
            $ramCritical,
            $diskCritical,
        ));*/

        $monitoringCenter = MonitoringCenter::get($this->data->id);

        //at the moment we only check critical ram and cpu
        $resources = array(
            'ram' => $ramCritical,
            'cpu' => $cpuCritical);

        $result = false;

        foreach ($resources as $resource => $limit)
        {
            echo "Checking ".$resource." of " . $this->data->name . "\n";
            $result = $monitoringCenter->checkReach($limit, $resource);

            if ($result)
            {
                break;
            }
        }
        if(!$result)
        {
            "Everything is OK!!\n\n";
        }
        return $result;

    }
}
