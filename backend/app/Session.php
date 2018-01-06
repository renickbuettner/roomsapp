<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 04.01.18
 * Time: 10:00
 */

namespace renickbuettner\App;


use http\Env\Request;

class Session
{

    public function delete($f3, $params)
    {
        try {
            session_unset();
        } catch (\Exception $e){}
        $f3->error(204);
    }

    public function get($f3, $params)
    {
        if ($this->validate())
        {
            $usr = User::createFromDatabase($f3, $_SESSION["email"])[0];
            if($usr instanceof User) {
                (new Response([
                    ["user" => $usr->toArray()]
                ]))->send();
                return;
            }
        } else
            $this->invalidSession();
    }

    public function post($f3, $params)
    {
        try {
            parse_str(file_get_contents('php://input'), $_PUT);
            $usr = User::createFromDatabase($f3, $_PUT["email"])[0];
            if ($usr INSTANCEOF User) {
                if ($usr->auth($_PUT["password"])) {
                    $_SESSION["uuid"]  = $usr->uuid;
                    $_SESSION["email"] = $usr->email;
                    (new Response($usr->toArray()))->send();
                    return;
                }
            }
        } catch (\Exception $e){}
        $this->invalidSession();
    }

    private function validate()
    {
        if(isset($_SESSION) && $_SESSION["email"] != null)
            return true;
        else return false;
    }

    private function invalidSession()
    {
        (new Response([
            "session" => null,
            "expecting" => ["email", "password"]
        ]))->send();
    }

}