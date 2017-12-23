<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 07.12.17
 * Time: 18:11
 */

namespace renickbuettner\App;


class Api
{

    public function __construct()
    {
        GLOBAL $f3;

        header("Content-type: application/json");

        $f3->route('GET|POST|PUT|DELETE /', function ($f3){
            echo 123;
        });

        /**
         *  [ ROOM OPERATIONS ]
         */
        $f3->route('GET /rooms', 'Room->getRooms');
        $f3->route('POST /rooms', 'Room->addRoom');

        //$f3->route('GET /rooms/@id', 'Room->getRoom');
        //$f3->route('DELETE /rooms/@id', 'Room->deleteRoom');
        //$f3->route('PUT /rooms/@id', 'Room->updateRoom');

        //$f3->route('GET /rooms/@id/reservations', 'Reservation->getReservations');
        //$f3->route('DELETE /rooms/@id/reservations', 'Reservation->deleteReservation');
        //$f3->route('PUT /rooms/@id/reservations', 'Reservation->updateReservation');

        /**
         *  [ USER OPERATIONS ]
         */
        //$f3->route('GET /users', 'User->getUsers');
        //$f3->route('POST /users', 'User->addUser');

        //$f3->route('GET /users/@id', 'User->getUser');
        //$f3->route('DELETE /users/@id', 'User->deleteUser');
        //$f3->route('PUT /users/@id', 'User->updateUser');



    }

    public static function about($f3)
    {
        echo json_encode(
            [
                "RoomsApp",
                "Developer" => "Renick Büttner",
                "Version" => App::VERSION,
                "Copyright" => "© 2017 Renick Büttner"
            ],
            JSON_PRETTY_PRINT);
    }

}