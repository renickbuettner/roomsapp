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
                    try {
                        $STREAM .= file_get_contents($DIR . $item) . PHP_EOL;
                    } catch (\Exception $e){}
                }
            }
        }

        header("Content-Type: application/javascript; charset=utf-8");
        echo $STREAM;
    }

    public static function css()
    {
        $STREAM = "";

        $FILES = [
            "ui/css/animate.css",
            "ui/css/flatpickr.css",
            "ui/css/flatpickr.theme.dark.css",
            "../app.css"
        ];

        foreach ($FILES as $f)
        {
            try {
                $STREAM .= file_get_contents($f).PHP_EOL;
            } catch (\Exception $e){}
        }

        header("Content-Type: text/css; charset=utf-8");
        echo $STREAM;
    }

}