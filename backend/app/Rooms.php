<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.12.17
 * Time: 18:05
 */

namespace renickbuettner\App;


class Rooms
{

    public function getRooms($f3){
        $res = new Response(
            [$this->createFromDatabase($f3)]
        );
        $res->send();
    }

    public function getRoom($f3, $params){
        $res = new Response(
            [$this->createFromDatabase($f3, $params["id"])]
        );
        $res->send();
    }

    public function addRoom($f3){

    }

    public function deleteRoom($f3){

    }

    public function updateRoom($f3){

    }

    private function createFromDatabase($f3, $id = "*"){
        $con = $f3->get("Database");
        $arr = [];
        foreach ($con->getRooms($id) as $r)
        {
            $arr[] = [
                    "id" => $r["id"],
                    "name" => $r["name"],
                    "location" => $r["location"],
                    "reservations" => [
                        "href" => "/rooms/".$r["id"]."/reservations"
                    ]
                ];
        }
        return $arr;
    }

}