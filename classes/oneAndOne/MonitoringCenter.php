<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 14/03/2016
 * Time: 9:40
 */

namespace oneAndOne;


class MonitoringCenter extends Element
{
    static $segment = "/monitoring_center";

    public static function get($id = null)
    {
        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
        $url= \AppConfig::getData('API')['url']. static::$segment.'/'.$id;
        $result = $curl->get($url);
    }


}