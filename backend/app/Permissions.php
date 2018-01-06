<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 06.01.18
 * Time: 23:36
 */

namespace renickbuettner\App;


class Permissions
{

    private static function compare($level)
    {
        return (floatval($_SESSION["group"]) >= $level);
    }

    public static function canCreateReservations()
    {
        return Permissions::compare(10);
    }

    public static function canEditAnyReservation()
    {
        return Permissions::compare(50);
    }

    public static function canEditRooms()
    {
        return Permissions::compare(65);
    }

    public static function canViewUsers()
    {
        return Permissions::compare(80);
    }

    public static function canEditUsers()
    {
        return Permissions::compare(90);
    }

}