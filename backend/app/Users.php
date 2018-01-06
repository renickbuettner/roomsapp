<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 06.01.18
 * Time: 16:22
 */

namespace renickbuettner\App;


class Users
{

    /**
     * Binding api to object layer
     *
     * @param $f3
     * @param $params
     */

    public static function getUser($f3, $params)
    {
        try {
            $email = base64_decode($params["ref"]);
            $usr = (User::createFromDatabase($f3, $email))[0];
            if( $usr instanceof User) {
                (new Response(
                    [$usr->toArray()]
                ))->send();
                return;
            }
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public static function updateUser($f3, $params)
    {
        try {
            $email = base64_decode($params["ref"]);
            $usr = (User::createFromDatabase($f3, $email))[0];
            if( $usr instanceof User) {

                parse_str(file_get_contents('php://input'), $_PUT);

                if(isset($_PUT["name"]))
                    $usr->name  = $_PUT["name"];

                if(isset($_PUT["group"]))
                    $usr->group = $_PUT["group"];

                if(isset($_PUT["email"]))
                    $usr->email = $_PUT["email"];

                if(isset($_PUT["password"]))
                    $usr->changePassword($_PUT["password"]);

                $usr->save($f3);

                (new Response(
                    [$usr->toArray()]
                ))->send();
                return;
            }
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function getUsers($f3, $params)
    {
        try {
            foreach (User::createFromDatabase($f3) as $user)
                $r[] = $user->toArray();
            (new Response($r))->send();
            return;
        } catch (\Exception $e){}
        $f3->error(404);
    }

    public function createUser($f3)
    {
        try {
            parse_str(file_get_contents('php://input'), $_PUT);

            try {
                $usr = (User::createFromDatabase($f3, $_PUT["email"]))[0];
                if( $usr instanceof User) {
                    $f3->error(409);
                    return;
                }
            } catch (\Exception $e){}

            $usr = new User($_PUT["name"], $_PUT["email"], $_PUT["group"], null, null);
            $usr->save($f3);

            try {
                $usr = (User::createFromDatabase($f3, $usr->email))[0];
                if( $usr instanceof User) {
                    $usr->changePassword($_PUT["password"]);
                }
            } catch (\Exception $e){}

            var_dump($_PUT);
            var_dump($usr);

            (new Response(
                [$usr->toArray()]
            ))->send();
            return;

        } catch (\Exception $e) {}
    }

    public function deleteUser($f3, $params)
    {
        try {
            $email = base64_decode($params["ref"]);
            $usr = (User::createFromDatabase($f3, $email))[0];
            if( $usr instanceof User) {

                $usr->remove($f3);

                (new Response(
                    [$usr->toArray()]
                ))->send();
                return;
            }
        } catch (\Exception $e){}
        $f3->error(404);
    }

}