<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 11:42
 */

include_once 'autoload.php';

AppConfig::readFile();
print_r(AppConfig::getData('API'));