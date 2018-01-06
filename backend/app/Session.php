<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 04.01.18
 * Time: 10:00
 */

namespace renickbuettner\App;


class Session
{

    public function delete()
    {
        session_unset();
        session_destroy();
    }

    public function get()
    {

    }

    public function post()
    {

    }

}