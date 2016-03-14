<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 14:22
 */

namespace oneAndOne;

class Server extends Element
{
    static $segment = "/servers";

    public function optimize()
    {
		$monitoringId = $this->data->monitoring_policy->id;
        $monitoring = MonitoringPolicy::get($monitoringId);

        if ($this->checkThresholds($monitoring->thresholds)) {


            // todo: we have to check if we must to clone the server
            $newServer = $this->cloneServer();


            // wait until the server has an ip
            $count = 0;
            $ip = null;

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

    /**
 * @param $id
 * @return mixed
 * @throws \Exception
 */
    public function cloneServer()
    {
        //we check if serveris in correct status
        if($this->data->status->state === 'POWERED_ON' || $this->data->status->state === 'POWERED_OFF'){
            $url = \AppConfig::getData('API')['url'].static::$segment."/".$this->data->id."/clone";
            $postParams = "{\"name\": \"Server Cloned at ".date('Y-m-d H:i:s')."\"}";
            $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);

            $result = $curl->post($url, $postParams);

			return $this->createObject($result);
        }

        throw new \Exception("Can't clone the server in actual state");

    }

    public function checkThresholds($thresholds)
    {
        $cpuWarning = $thresholds->cpu->warning->value;
        $cpuCritical = $thresholds->cpu->critical->value;
        $ramWarning = $thresholds->ram->warning->value;
        $ramCritical = $thresholds->ram->critical->value;
        $diskWarning = $thresholds->disk->warning->value;
        $diskCritical = $thresholds->disk->critical->value;

        /*print_r(array(
            $cpuWarning,
            $cpuCritical,
            $ramWarning,
            $ramCritical,
            $diskWarning,
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
