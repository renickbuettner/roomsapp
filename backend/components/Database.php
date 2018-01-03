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

    private $path = ".appData/app.db", $data;

    public function __construct()
    {
        $this->data = new \PDO('sqlite:'.$this->path);
    }

    public static function getInstance()
    {
        GLOBAL $App;
        return (
            $App->getDB()
        );
    }

    public function prepareDatabase() {

        // do some commands for creating tables if not exists...
    }

}