<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 11:42
 */

spl_autoload_register(function ($class) {
    include 'class/' . $class . '.php';
});