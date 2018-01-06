<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.01.18
 * Time: 00:11
 */

$DEBUG  = TRUE;
$STREAM = "";
$DIR    = "roomsjs/";

foreach (scandir($DIR) as $item)
{
    if($item != "." && $item != ".."){
        if($DEBUG || !$DEBUG && $item != "test.js") {
            $STREAM .= file_get_contents($DIR . $item) . PHP_EOL;
        }
    }
}

header("Content-Type: application/javascript;charset=utf-8");
echo $STREAM;