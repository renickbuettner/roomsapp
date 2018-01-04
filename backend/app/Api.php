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

    public function __construct($f3)
    {

        $f3->route('GET|POST|PUT|DELETE /', 'renickbuettner\App\App::hello');

        /**
         *  [ ROOM OPERATIONS ]
         */
        $f3->route('GET /rooms', 'renickbuettner\App\Rooms->getRooms');
        //$f3->route('POST /rooms', 'renickbuettner\App\Rooms->addRoom');

        $f3->route('GET /rooms/@id', 'renickbuettner\App\Rooms->getRoom');
        //$f3->route('DELETE /rooms/@id', 'renickbuettner\App\Rooms->deleteRoom');
        //$f3->route('PUT /rooms/@id', 'renickbuettner\App\Rooms->updateRoom');

        //$f3->route('GET /rooms/@id/reservations', 'renickbuettner\App\Reservation->getReservations');
        //$f3->route('DELETE /rooms/@id/reservations', 'renickbuettner\App\Reservation->deleteReservation');
        //$f3->route('PUT /rooms/@id/reservations', 'renickbuettner\App\Reservation->updateReservation');

        /**
         *  [ USER OPERATIONS ]
         */
        //$f3->route('GET /users', 'renickbuettner\App\Users->getUsers');
        //$f3->route('POST /users', 'renickbuettner\App\Users->addUser');


        /**
         *  [ SESSION OPERATIONS ]
         */
        $f3->route('GET /session', 'renickbuettner\App\Session->get');
        $f3->route('POST /session', 'renickbuettner\App\Session->post');
        $f3->route('DELETE /session', 'renickbuettner\App\Session->delete');



        //$f3->route('GET /users/@id', 'renickbuettner\App\Users->getUser');
        //$f3->route('DELETE /users/@id', 'renickbuettner\App\Users->deleteUser');
        //$f3->route('PUT /users/@id', 'renickbuettner\App\Users->updateUser');



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