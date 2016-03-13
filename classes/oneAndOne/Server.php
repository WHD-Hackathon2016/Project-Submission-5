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
		// $realServer = ServerIP::get($this->data->id);

		$serverId = $this->data->id;

        $monitoringId = $this->getMonitoringId($serverId);
        $monitoring = (new MonitoringPolicy())->get($monitoringId);
        //print_r($monitoring);

        // todo: we have to check if we must to clone the server
        $newServer = $this->cloneServer($serverId);

        // wait until the server has an ip
        $count = 0;
        $ip = null;
        do{
            $result = parent::get($newServer->id)->content;
            if(isset($result->ips[0]->id))
            {
                $ip = $result->ips[0]->id;
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
    public function cloneServer($id)
    {

        $url = \AppConfig::getData('API')['url'].$this->segment."/".$id."/clone";
        $postParams = "{\"name\": \"Server Cloned at ".date('Y-m-d H:i:s')."\"}";
        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);

        $result = $curl->post($url, $postParams);
        return $result->content;
    }

    public function getMonitoringId($serverId)
    {
		$server = parent::get($serverId);

        if (isset($server->content->monitoring_policy->id) )
        {
            return $server->content->monitoring_policy->id;
        }

        throw new \Exception("Server is not monitored");
    }






}