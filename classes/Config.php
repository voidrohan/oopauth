<?php
/**
 * Created by PhpStorm.
 * User: nullptr
 * Date: 3/22/2018
 * Time: 4:29 PM
 */
//config class

class Config {

    public static function get($path = null)
    {
        if($path){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach($path as $bit)
            {
                if(isset($config[$bit]))
                {
                    $config = $config[$bit];
                }
            }

            return $config;
        }
        return false;
    }
}