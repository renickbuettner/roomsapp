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

    public function getReservations($id)
    {
        try {
            if($id != "*"){
                return $this->db->exec(
                    "SELECT * FROM reservations WHERE id=:id", ["id"=>$id]);
            } else {
                return $this->db->exec(
                    "SELECT * FROM reservations");
            }
        } catch (\Exception $e){
            return null;
        }
    }

    public function filterReservations($key, $val)
    {
        try {
            return $this->db->exec(
                "SELECT * FROM reservations WHERE `".$key."`=?;",
                [$val]);
        } catch (\Exception $e){
            return null;
        }
    }

    public function writeReservation(Reservation $res)
    {
        try {
            if($res->uuid == null)
            {
                $this->db->exec(
                    "INSERT INTO reservations (`room`, `user`, `notes`, `begin`, `end`) VALUES (:room, :user, :notes, :begin, :end);",
                    [
                        ":room" => $res->room,
                        ":user" => $res->user,
                        ":notes" => $res->notes,
                        ":begin" => $res->begin,
                        ":end" => $res->end
                    ]);
                return $this->db->pdo()->lastInsertId();
            } else {
                $this->db->exec(
                    "UPDATE reservations SET `room`=:room, `user`=:user, `notes`=:notes, `begin`=:begin, `end`=:end ".
                    "WHERE `id`=:id;",
                    [
                        ":id" => $res->uuid,
                        ":room" => $res->room,
                        ":user" => $res->user,
                        ":notes" => $res->notes,
                        ":begin" => $res->begin,
                        ":end" => $res->end
                    ]);
            }
        } catch (\Exception $e){}
    }

    public function removeReservation(Reservation $res)
    {
        try {
            $this->db->exec(
                "DELETE FROM reservations WHERE `id`=:id;",
                [
                    ":id" => $res->uuid
                ]);
        } catch (\Exception $e){}
    }

    public function countReservations($room, $begin, $end)
    {
        try {
            return $this->db->exec(
                "SELECT COUNT(*) as `int` FROM reservations WHERE `room` = :room AND `begin` <= :begin AND `end` >= :end ;",
                [
                    ":begin" => $begin,
                    ":end" => $end,
                    ":room" => $room
                ]);
        } catch (\Exception $e){}
    }

}
