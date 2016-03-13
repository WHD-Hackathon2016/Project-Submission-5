<?php

/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 11:32
 */
class AppConfig
{
    private static $data;
    public static function readFile()
    {
        self::$data = parse_ini_file('config/config.ini', true);
    }

    public static function getData($data)
    {
        if(empty(self::$data))
        {
            self::readFile();
        }
        if(array_key_exists($data,self::$data)){
            return self::$data[$data];
        }

        throw new Exception('Data dont exists');
    }
}