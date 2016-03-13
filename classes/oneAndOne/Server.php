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
    protected $segment = "/servers";

    public function optimize($ipId)
    {
        $serverId = (new ServerIP())->getServerId($ipId);

        $monitoringId = $this->getMonitoringId($serverId);
        $monitoring = (new MonitoringPolicy())->get($monitoringId);
        //print_r($monitoring);

        // todo: we have to check if we must to clone the server
        $newServer = $this->cloneServer($serverId);
        return $newServer->ips[0]->id;
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