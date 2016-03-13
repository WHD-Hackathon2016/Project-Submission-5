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
        $ip = (new ServerIP())->get($ipId);
        $serverId = $ip->getServerId();

        $server = parent::get($serverId);
        $monitoringId = $server->getMonitoringId();
        $monitoring = (new MonitoringPolicy())->get($monitoringId);
        print_r($monitoring);
    }

    public function cloneServer()
    {

    }

    public function getMonitoringId()
    {
        if (isset($this->content->monitoring_policy->id) )
        {
            return $this->content->monitoring_policy->id;
        }

        throw new \Exception("Server is not monitored");
    }






}