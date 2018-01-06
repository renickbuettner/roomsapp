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

    public function __construct($f3)
    {
        $f3->set("Database", new Database($f3));
        $f3->set("Api", new Api($f3));
    }

    public static function hello() {
        (new Response([
            "RoomsApp" => [
                "version" => App::VERSION,
                "routes"  => [
                    "/rooms",
                    "/reservations",
                    "/users",
                    "/session"
                ],
                "about" => [
                    "developers" => [
                        [
                            "name" => "Renick Büttner",
                            "href" => "https://renickbuettner.de",
                            "twitter" => "@RenickB"
                        ]
                    ]
                ]
            ]
        ]))->send();
    }

}