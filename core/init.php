<?php
/**
 * Created by PhpStorm.
 * User: nullptr
 * Date: 3/22/2018
 * Time: 4:34 PM
 */

//Autoload classes
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'rohan12',
        'db' => 'oop'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user'
    )
);

spl_autoload_register(function($class) {
    require_once 'classes/'. $class . '.php';
});

require_once 'functions/sanitize.php';