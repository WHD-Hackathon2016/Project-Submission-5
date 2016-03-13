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
    protected $segment = "/public_ips";

    public function getServerId()
    {
        if (isset($this->content->assigned_to->id) )
        {
            return $this->content->assigned_to->id;
        }

        throw new \Exception("Ip has not server assigned");
    }
}