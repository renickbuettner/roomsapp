<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.12.17
 * Time: 18:05
 */

namespace renickbuettner\App;


class Reservations
{

    public function getReservations($f3){
        try {
            foreach (Reservations::createFromDatabase($f3) as $res)
                $r[] = $res->toArray();
            (new Response($r))->send();
            return;
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function getReservationsByRoom($f3, $params){
        try {
            $con = $f3->get("Database");
            $arr = [];
            foreach ($con->getReservations("room", $params["ref"]) as $r)
                $arr[] = new Reservation(
                    $r["begin"],
                    $r["end"],
                    $r["user"],
                    $r["notes"],
                    $r["room"],
                    $r["id"]);

            (new Response($arr))->send();
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function getReservationByID($f3, $params){
        try {
            $con = $f3->get("Database");
            $arr = [];
            foreach ($con->getReservations("id", $params["ref"]) as $r)
                $arr[] = new Reservation(
                    $r["begin"],
                    $r["end"],
                    $r["user"],
                    $r["notes"],
                    $r["room"],
                    $r["id"]);

            (new Response($arr))->send();
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function create($f3){
        try {
            parse_str(file_get_contents('php://input'), $params);

            try {
                $res = (Reservations::createFromDatabase($f3, $params["ref"]))[0];
                if($res instanceof Reservation) {
                    $f3->error(409);
                    return;
                }
            } catch (\Exception $e){}

            $res = new Reservation(
                $params["begin"],
                $params["end"],
                $_SESSION["uuid"],
                $params["notes"],
                $params["begin"],
                $params["end"]);

            $res->save($f3);

            (new Response(
                [$res->toArray()]
            ))->send();
            return;

        } catch (\Exception $e) {}
        $f3->error(401);
    }

    public function remove($f3, $params){
        try {
            $res = (Reservations::createFromDatabase($f3, $params["ref"]))[0];
            if($res instanceof Reservation) {

                $res->remove($f3);

                (new Response(
                    [$res->toArray()]
                ))->send();
                return;
            }
        } catch (\Exception $e){}
        $f3->error(204);
    }

    public function update($f3, $params){
        try {
            $res = (Reservation::createFromDatabase($f3, $params["ref"]))[0];
            if($res instanceof Reservation) {

                parse_str(file_get_contents('php://input'), $_PUT);

                if(isset($_PUT["begin"]))
                    $res->begin  = $_PUT["begin"];

                if(isset($_PUT["end"]))
                    $res->end = $_PUT["end"];

                if(isset($_PUT["user"]))
                    $res->user  = $_PUT["user"];

                if(isset($_PUT["notes"]))
                    $res->notes = $_PUT["notes"];

                if(isset($_PUT["room"]))
                    $res->room  = $_PUT["room"];

                $res->save($f3);

                (new Response(
                    [$res->toArray()]
                ))->send();
                return;
            }
        } catch (\Exception $e){}
        $f3->error(404);
    }

    private function createFromDatabase($f3, $id = "*"){
        $con = $f3->get("Database");
        $arr = [];
        foreach ($con->getReservations($id) as $r)
            $arr[] = new Reservation(
                $r["begin"],
                $r["end"],
                $r["user"],
                $r["notes"],
                $r["room"],
                $r["id"]);
        return $arr;
    }

}