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

    public $username, $hash, $group, $uuid;

    public function addUser($username, $pwd, $group)
    {

    }

    public function removeUser($uuid)
    {

    }

    private function getHash($pwd, User $u)
    {
        return (
          sha1(md5($pwd.$u->uuid).$u->group)
        );
    }

}
