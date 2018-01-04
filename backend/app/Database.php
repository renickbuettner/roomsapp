<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.12.17
 * Time: 18:20
 */

namespace renickbuettner\App;


class Database
{

    private $path = ".appData/roomsapp.sqlite3", $data;

    public function __construct()
    {
        $this->data = new \DB\SQL('sqlite:' . $this->path);
    }

    public static function getInstance()
    {
        GLOBAL $App;
        return (
            $App->getDB()
        );
    }

}