<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.01.18
 * Time: 13:11
 */

namespace renickbuettner\App;


class Frontend
{

    public static function get()
    {
        header('Access-Control-Allow-Origin: *');
        echo file_get_contents("_app.html");
    }

    public static function js()
    {
        $DEBUG  = TRUE;
        $STREAM = "";
        $DIR    = "../roomsjs/";

        foreach (scandir($DIR) as $item)
        {
            if($item != "." && $item != ".."){
                if($DEBUG || !$DEBUG && $item != "test.js") {
                    $STREAM .= file_get_contents($DIR . $item) . PHP_EOL;
                }
            }
        }

        header("Content-Type: application/javascript; charset=utf-8");
        echo $STREAM;
    }

}