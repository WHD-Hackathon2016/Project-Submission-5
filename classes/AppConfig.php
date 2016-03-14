<?php
/**
 * @package    1&1 Server monitoring
 *
 * @author     Francisco Aramayo Martinez <faramayo@arsys.es>
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 *
 * @license    GNU General Public License version 3 or later; see LICENSE
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