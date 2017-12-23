<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.12.17
 * Time: 18:05
 */

namespace renickbuettner\App;


class Room
{

    private $Name, $Location, $reservations;

    public function getRooms($f3){
        echo json_encode("rooms", JSON_PRETTY_PRINT);
    }

    public function getRoom($f3){

    }

    public function addRoom($f3){

    }

    public function deleteRoom($f3){

    }

    public function updateRoom($f3){

    }


}