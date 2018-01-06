<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.12.17
 * Time: 18:06
 */

namespace renickbuettner\App;


class Reservation
{

    public  $begin,
            $end,
            $user,
            $uuid;

    public function __construct($begin, $end, $user, $uuid)
    {
        $this->begin = $begin;
        $this->end   = $end;
        $this->uuid  = $uuid;
        $this->user  = $user;
    }

    public function save($f3){

    }

    public function delete($f3){

    }

    public function toArray()
    {

    }

}