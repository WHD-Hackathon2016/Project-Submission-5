<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 14:22
 */

namespace oneAndOne;


class ServerIP extends Element
{
    static $segment = "/public_ips";

    public function getServerId($ipId)
    {
		$ip = parent::get($ipId);

        if (isset($ip->content->assigned_to->id) )
        {
            return $ip->content->assigned_to->id;
        }

        throw new \Exception("Ip has not server assigned");
    }
}