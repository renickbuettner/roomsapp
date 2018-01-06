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
        try {
            foreach (Rooms::createFromDatabase($f3) as $room)
                $r[] = $room->toArray();
            (new Response($r))->send();
            return;
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function getRoom($f3, $params){
        try {
            $room = (Rooms::createFromDatabase($f3, $params["ref"]))[0];
            if($room instanceof Room) {
                (new Response(
                    [$room->toArray()]
                ))->send();
                return;
            }
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function createRoom($f3){
        try {
            parse_str(file_get_contents('php://input'), $params);

            try {
                $room = (Rooms::createFromDatabase($f3, $params["email"]))[0];
                if( $room instanceof Room) {
                    $f3->error(409);
                    return;
                }
            } catch (\Exception $e){}

            $room = new Room($params["name"], $params["location"]);
            $room->save($f3);

            (new Response(
                [$room->toArray()]
            ))->send();
            return;

        } catch (\Exception $e) {}
        $f3->error(401);
    }

    public function deleteRoom($f3, $params){
        try {
            $room = (Rooms::createFromDatabase($f3, $params["ref"]))[0];
            if($room instanceof Room) {

                $room->remove($f3);

                (new Response(
                    [$room->toArray()]
                ))->send();
                return;
            }
        } catch (\Exception $e){}
        $f3->error(204);
    }

    public function updateRoom($f3, $params){
        try {
            $room = (Rooms::createFromDatabase($f3, $params["ref"]))[0];
            if($room instanceof Room) {

                parse_str(file_get_contents('php://input'), $_PUT);

                if(isset($_PUT["location"]))
                    $room->location  = $_PUT["location"];

                if(isset($_PUT["name"]))
                    $room->name = $_PUT["name"];

                $room->save($f3);


                (new Response(
                    [$room->toArray()]
                ))->send();
                return;
            }
        } catch (\Exception $e){}
        $f3->error(404);
    }

    private function createFromDatabase($f3, $id = "*"){
        $con = $f3->get("Database");
        $arr = [];
        foreach ($con->getRooms($id) as $r)
            $arr[] = new Room($r["name"], $r["location"], $r["id"]);
        return $arr;
    }

}