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
            foreach ($con->filterReservations("room", $params["ref"]) as $r)
                $arr[] = (new Reservation(
                    $r["begin"],
                    $r["end"],
                    $r["user"],
                    $r["notes"],
                    $r["room"],
                    $r["id"]))->toArray();
            (new Response($arr))->send();
            return;
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function filterReservationsByRoom($f3, $params){
        try {
            $con = $f3->get("Database");
            $arr = [];
            foreach ($con->filterReservationsInTimespan("room", $params) as $r)
                $arr[] = (new Reservation(
                    $r["begin"],
                    $r["end"],
                    $r["user"],
                    $r["notes"],
                    $r["room"],
                    $r["id"]))->toArray();
            (new Response($arr))->send();
            return;
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function getReservationsByID($f3, $params){
        try {
            $con = $f3->get("Database");
            $arr = [];
            foreach ($con->filterReservations("id", $params["ref"]) as $r)
                $arr[] = (new Reservation(
                    $r["begin"],
                    $r["end"],
                    $r["user"],
                    $r["notes"],
                    $r["room"],
                    $r["id"]))->toArray();
            (new Response($arr))->send();
            return;
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function create($f3, $params){
        try {

            if(!Permissions::canCreateReservations()){
                $f3->error(403);
                return;
            }

            parse_str(file_get_contents('php://input'), $_PUT);

            $begin  = floatval($_PUT["begin"]);
            $end    = floatval($_PUT["end"]);
            $isFree = $this->roomIsFree($f3, $params["ref"], $begin, $end);

            if ($isFree && $begin < $end)
            {
                $res = new Reservation(
                    $begin,
                    $end,
                    $_SESSION["uuid"],
                    $_PUT["notes"],
                    $params["ref"],
                    null);

                $res->save($f3);

                (new Response(
                    [$res->toArray()]
                ))->send();
                return;
            } else {
                $f3->error(406);
                return;
            }
        } catch (\Exception $e) {}
        $f3->error(401);
    }

    public function remove($f3, $params){
        try {
            $res = (Reservations::createFromDatabase($f3, $params["ref"]))[0];
            if($res instanceof Reservation) {

                if(!Permissions::canEditAnyReservation() && $res->user != $_SESSION["uuid"]){
                    $f3->error(403);
                    return;
                }

                $res->remove($f3);

                (new Response(
                    [$res->toArray()]
                ))->send();
                return;
            }
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function update($f3, $params){
        try {
            $res = (Reservations::createFromDatabase($f3, $params["ref"]))[0];
            if($res instanceof Reservation) {

                if(!Permissions::canEditAnyReservation() && $res->user != $_SESSION["uuid"]){
                    $f3->error(403);
                    return;
                }

                parse_str(file_get_contents('php://input'), $_PUT);

                if(isset($_PUT["begin"]) && strlen($_PUT["begin"]) > 0)
                    $res->begin  = $_PUT["begin"];

                if(isset($_PUT["end"]) && strlen($_PUT["end"]) > 0)
                    $res->end = $_PUT["end"];

                if(isset($_PUT["user"]) && strlen($_PUT["user"]) > 0)
                    $res->user  = $_PUT["user"];

                if(isset($_PUT["notes"]) && strlen($_PUT["notes"]) > 0)
                    $res->notes = $_PUT["notes"];

                if(isset($_PUT["room"]) && strlen($_PUT["room"]) > 0)
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

    private function roomIsFree($f3, $room, $begin, $end){
        try {
            $con = $f3->get("Database");
            if($con->countReservations($room, $begin, $end)[0]["int"] != 0)
                return false;
        } catch (\Exception $e){}
        return true;
    }

}