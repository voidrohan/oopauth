<?php
/**
 * Created by PhpStorm.
 * User: nullptr
 * Date: 3/22/2018
 * Time: 4:34 PM
 */

//BASIC escape mechanism
function escape($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}