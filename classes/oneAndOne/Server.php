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

        // todo: we have to check if we must to clone the server
        $newServer = $this->cloneServer();

        // wait until the server has an ip
        $count = 0;
        $ip = null;
        do{
            //$result = parent::get($newServer->id)->content;
            $newServer = Server::get($newServer->id);
            if(isset($newServer->ips[0]->id))
            {
                $ip = $newServer->ips[0]->id;
            }
            ++$count;
            sleep(5);
        }while (is_null($ip) && $count < 20);

        return $ip;
    }

    /**
 * @param $id
 * @return mixed
 * @throws \Exception
 */
    public function cloneServer()
    {
        print $this->data->status->state."\n";
        //we check if serveris in correct status
        if($this->data->status->state === 'POWERED_ON' || $this->data->status->state === 'POWERED_OFF'){
            $url = \AppConfig::getData('API')['url'].static::$segment."/".$this->data->id."/clone";
            $postParams = "{\"name\": \"Server Cloned at ".date('Y-m-d H:i:s')."\"}";
            $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);

            $result = $curl->post($url, $postParams);
            return $result->content;
        }

        throw new \Exception("Can't clone the server in actual state");

    }
}