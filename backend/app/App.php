<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.12.17
 * Time: 18:10
 */

namespace renickbuettner\App;

date_default_timezone_set('Europe/Berlin');

class App
{
    const VERSION = "1.0";

    private $rm, $db, $api;

    public function __construct($f3)
    {
        //$db  = new Database($f3);
        //$api = new Api($f3);
        $f3->set("Database", new Database($f3));
        $f3->set("Api", new Api($f3));
    }

    public static function hello() {
        (new Response([
            "RoomsApp" => [
                "Version" => App::VERSION,
                "Routes"  => [
                    "/rooms",
                    "/users",
                    "/reservations"
                ]
            ]
        ]))->send();
    }

}