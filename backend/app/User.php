<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.12.17
 * Time: 18:14
 */

namespace renickbuettner\App;


class User
{

    public  $name,
            $email,
            $passwd,
            $group,
            $uuid;

    public function __construct($name, $email, $group, $uuid, $passwd)
    {
        $this->email  = $email;
        $this->name   = $name;
        $this->group  = $group;
        $this->uuid   = $uuid;
        $this->passwd = $passwd;
    }

    public function auth($passwd)
    {
        return ($this->passwd == $this->getHash($passwd)) ? true:false;
    }

    public function remove($f3){
        try {
            $con = $f3->get("Database");
            $con->removeUser($this);
        } catch (\Exception $e){}
    }

    public function save($f3){
        try {
            $con = $f3->get("Database");
            $con->writeUser($this);
        } catch (\Exception $e){}
    }

    private function getHash($pwd)
    {
        return (
        //  sha1((base64_encode($pwd).base64_encode($this->uuid)))
            $pwd
        );
    }

    public function changePassword($pwd)
    {
        $this->passwd = $this->getHash($pwd);
    }

    public static function createFromDatabase($f3, $email = "*"){
        $arr = [];
        try {
            $con = $f3->get("Database");
            foreach ($con->getUsers($email) as $u)
            {
                $arr[] = new User(
                    $u["name"],
                    $u["email"],
                    $u["group"],
                    $u["id"],
                    $u["passwd"]);
            }
        } catch (\Exception $e) {
            return null;
        }
        return $arr;
    }

    public function toArray()
    {
        return [
            "name"  => $this->name,
            "email" => $this->email,
            "group" => $this->group,
            "uuid"  => $this->uuid
        ];
    }
}
