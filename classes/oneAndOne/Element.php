<?php

namespace oneAndOne;
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 13:53
 */
class Element implements IElement
{
    protected $id;
    protected $name;
    protected $date;

    protected $segment;

    public function get($id)
    {
        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
        $url= \AppConfig::getData('API')['url'].$this->segment.'/'.$id;
        $curl->get($url);
    }
}