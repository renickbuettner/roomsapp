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
            foreach($arr as $key => $item){
                $res[$item->uuid]["name"] = $item->name;
                $res[$item->uuid]["location"] = $item->location;

                foreach ($con->filterReservations("room", $item->uuid) as $r)
                    $res[$item->uuid]["reservations"][] = $r;
            }

            (new Response($res))->send();

        } catch (\Exception $e){}
    }

}