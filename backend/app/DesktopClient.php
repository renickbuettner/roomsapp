<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 13.03.18
 * Time: 19:40
 */

namespace renickbuettner\App;


class DesktopClient
{

    public function get($f3)
    {
        try {
            $con = $f3->get("Database");
            $arr = [];
            foreach ($con->getRooms("*") as $r)
                $arr[] = new Room($r["name"], $r["location"], $r["id"]);

            $res = [];
            $i = 0;
            foreach($arr as $key => $item){

                $entry["uuid"] = $item->uuid;
                $entry["name"] = $item->name;
                $entry["location"] = $item->location;

                $entry["reservations"] = [];
                $b = 0;
                foreach ($con->getReservationsForClient("room", $item->uuid) as $r) {
                    $b++;
                    $entry["reservations"][$b] = $r;
                }

                $i++;
                $res[$i] = $entry;
                unset($entry);
            }

            (new Response($res))->send();

        } catch (\Exception $e){}
    }

}