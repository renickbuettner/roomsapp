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

    private $path = "../appData/roomsapp.sqlite3",
            $db;

    public function __construct()
    {
        $this->db = new \DB\SQL('sqlite:' . $this->path);
    }

    public function getRooms($id)
    {
        try {
            if($id != "*"){
                return $this->db->exec(
                    'SELECT * FROM rooms WHERE id=:id', ["id"=>$id]);
            } else {
                return $this->db->exec(
                    'SELECT * FROM rooms');
            }
        } catch (\Exception $e){
            return $e;
        }
    }

}