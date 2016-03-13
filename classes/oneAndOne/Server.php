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
        print_r($monitoring);
    }

    public function cloneServer()
    {

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