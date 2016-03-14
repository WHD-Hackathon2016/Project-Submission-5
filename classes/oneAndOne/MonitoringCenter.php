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
    const PERIOD = 'LAST_HOUR';
    const CRITICAL_INTERVAL = 4; // 4 times of 5 minutes = 20 minutes

    /**
     * @param null $id
     * @return $this
     * @throws \Exception
     */
    public static function get($id = null)
    {
        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
        $url= \AppConfig::getData('API')['url']. static::$segment.'/'.$id.'?period='.self::PERIOD;
        $result = $curl->get($url);

        return static::createObject($result);
    }

    /**
     * @param $limit
     * @param $resource
     * @return bool
     */
    public function checkReach($limit, $resource)
    {
        try {
            $data = $this->data->$resource->data;
        } catch (Exception $e) {
            throw new \Exception("Resource not found");
        }

        $reach = false;
        foreach ($this->getLastValues($data) as $value)
		{
            if($value->used_percent > $limit)
            {
                echo $resource ." limit reached at " . $value->date."\n";
                $reach = true;
            }
        }

        return $reach;
    }

	public function checkInactive($limit, $resource)
	{
        try {
            $data = $this->data->$resource->data;
        } catch (Exception $e) {
            throw new \Exception("Resource not found");
        }

        $inactive = true;
        foreach ($this->getLastValues($data) as $value)
		{
            if($value->used_percent < $limit)
            {
                // echo $resource ." limit reached at " . $value->date."\n";
                $reach = false;
            }
        }

        return $reach;
	}

    public function getLastValues($dataArray)
    {
        $data = array_reverse($dataArray);
        $validData = array();
        $cont = self::CRITICAL_INTERVAL;
        foreach ($data as $item) {
            if(is_null($item))
            {
                continue;
            }
            $validData[] = $item;
            --$cont;
            if($cont === 0){
               break;
            }
        }

        return $validData;
    }




}