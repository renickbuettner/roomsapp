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
                    "SELECT * FROM rooms WHERE id=:id", ["id"=>$id]);
            } else {
                return $this->db->exec(
                    "SELECT * FROM rooms");
            }
        } catch (\Exception $e){
            return null;
        }
    }

    public function getUsers($email)
    {
        try {
            if($email != "*"){
                return $this->db->exec(
                    "SELECT * FROM users WHERE email=:email", ["email"=>$email]);
            } else {
                return $this->db->exec(
                    "SELECT * FROM users");
            }
        } catch (\Exception $e){
            return null;
        }
    }

    public function writeUser(User $user)
    {
        try {
            if($user->uuid == null)
            {
                $this->db->exec(
                    "INSERT INTO users (`name`, `email`, `passwd`, `group`) VALUES (:name, :email, :passwd, :group)",
                    [
                        ":name" => $user->name,
                        ":email" => $user->email,
                        ":passwd" => "",
                        ":group" => $user->group
                    ]);
            } else {
                $this->db->exec(
                    "UPDATE  users SET `name`=:name, `email`=:email, `group`=:group, `passwd`=:passwd ".
                    "WHERE `id`=:id",
                    [
                        ":id" => $user->uuid,
                        ":name" => $user->name,
                        ":email" => $user->email,
                        ":group" => $user->group,
                        ":passwd" => $user->passwd
                    ]);
            }
        } catch (\Exception $e){}
    }

    public function removeUser(User $user)
    {
        try {
            $this->db->exec(
                "DELETE FROM users WHERE `email`=:email;",
                [
                    ":email" => $user->email
                ]);
        } catch (\Exception $e){}
    }

    public function writeRoom(Room $room)
    {
        try {
            if($room->uuid == null)
            {
                $this->db->exec(
                    "INSERT INTO rooms (`name`, `location`) VALUES (:name, :location);",
                    [
                        ":name" => $room->name,
                        ":location" => $room->location
                    ]);
                return $this->db->pdo()->lastInsertId();
            } else {
                $this->db->exec(
                    "UPDATE rooms SET `name`=:name, `location`=:location ".
                    "WHERE `id`=:id;",
                    [
                        ":id" => $room->uuid,
                        ":name" => $room->name,
                        ":location" => $room->location
                    ]);
            }
        } catch (\Exception $e){}
    }

    public function removeRoom(Room $room)
    {
        try {
            $this->db->exec(
                "DELETE FROM rooms WHERE `id`=:id;",
                [
                    ":id" => $room->uuid
                ]);
        } catch (\Exception $e){}
    }





}
