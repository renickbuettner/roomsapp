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
            $uuid,
            $room,
            $notes;

    public function __construct($begin, $end, $user, $notes, $room, $uuid = null)
    {
        $this->begin = $begin;
        $this->end   = $end;
        $this->uuid  = $uuid;
        $this->user  = $user;
        $this->room  = $room;
        $this->notes = $notes;
    }

    public function save($f3){
        try {
            $con  = $f3->get("Database");
            $tmp = $con->writeReservation($this);
            if($this->uuid == null)
                $this->uuid = $tmp;
            unset($tmp);
        } catch (\Exception $e){}
    }

    public function remove($f3){
        try {
            $con = $f3->get("Database");
            $con->removeReservation($this);
        } catch (\Exception $e){}
    }

    public function toArray()
    {
        return [
            "uuid"  => $this->uuid,
            "user"  => $this->user,
            "room"  => $this->room,
            "notes" => $this->notes,
            "begin" => $this->begin,
            "end"   => $this->end
        ];
    }

}