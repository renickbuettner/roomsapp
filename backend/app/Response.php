<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 04.01.18
 * Time: 08:12
 */

namespace renickbuettner\App;


class Response
{

    public $content;

    public function __construct($res)
    {
        $this->content = $res;
    }

    public function send(){
        echo $this->encode();
    }

    private function encode()
    {
        header("Content-type: application/json");
        return json_encode(
            $this->content, JSON_PRETTY_PRINT
        );
    }
}