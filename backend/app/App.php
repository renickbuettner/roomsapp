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

    public function __construct()
    {
        $db  = new Database();
        $rm  = new RoomManagement();
        $api = new Api();
    }

    public function getDB()
    {
        return $this->db;
    }

}