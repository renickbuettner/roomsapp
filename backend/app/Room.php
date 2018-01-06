<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 06.01.18
 * Time: 20:23
 */

namespace renickbuettner\App;


class Room
{

    public  $uuid,
            $name,
            $location;

    private $reservations;

    public function __construct($name, $location, $uuid = null)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->location = $location;
    }

    public function save($f3)
    {
        try {
            $con  = $f3->get("Database");
            $tmp = $con->writeRoom($this);
            if($this->uuid == null)
                $this->uuid = $tmp;
            unset($tmp);
        } catch (\Exception $e){}
    }

    public function remove($f3)
    {
        try {
            $con = $f3->get("Database");
            $con->removeRoom($this);
        } catch (\Exception $e){}
    }

    public function toArray()
    {
        return [
            "uuid" => $this->uuid,
            "name" => $this->name,
            "location" => $this->location,
            "reservations" => [
                "href" => "/rooms/".$this->uuid."/reservations"]];
    }

}