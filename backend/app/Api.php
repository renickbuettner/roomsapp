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
        $f3->route('GET /', 'renickbuettner\App\Frontend::get');
        $f3->route('GET /app.js', 'renickbuettner\App\Frontend::js');
        $f3->route('GET /app.css', 'renickbuettner\App\Frontend::css');
        $f3->route('GET|POST|PUT|DELETE /api', 'renickbuettner\App\App::hello');

        $f3->route('GET /rooms', 'renickbuettner\App\Rooms->getRooms');
        $f3->route('GET /rooms/@ref', 'renickbuettner\App\Rooms->getRoom');
        $f3->route('POST /rooms', 'renickbuettner\App\Rooms->createRoom');
        $f3->route('DELETE /rooms/@ref', 'renickbuettner\App\Rooms->deleteRoom');
        $f3->route('PUT /rooms/@ref', 'renickbuettner\App\Rooms->updateRoom');

        $f3->route('GET /reservations', 'renickbuettner\App\Reservations->getReservations');
        $f3->route('GET /reservations/@ref', 'renickbuettner\App\Reservations->getReservationsByID');
        $f3->route('GET /rooms/@ref/reservations', 'renickbuettner\App\Reservations->getReservationsByRoom');
        $f3->route('GET /rooms/@ref/reservations/@begin/@end', 'renickbuettner\App\Reservations->filterReservationsByRoom');
        $f3->route('POST /rooms/@ref/reservations', 'renickbuettner\App\Reservations->create');
        $f3->route('PUT /reservations/@ref', 'renickbuettner\App\Reservations->update');
        $f3->route('DELETE /reservations/@ref', 'renickbuettner\App\Reservations->remove');

        $f3->route('GET /users', 'renickbuettner\App\Users->getUsers');
        $f3->route('GET /users/@ref', 'renickbuettner\App\Users->getUser');
        $f3->route('GET /session', 'renickbuettner\App\Session->get');
        $f3->route('POST /users', 'renickbuettner\App\Users->createUser');
        $f3->route('POST /session', 'renickbuettner\App\Session->post');
        $f3->route('PUT /users/@ref', 'renickbuettner\App\Users->updateUser');
        $f3->route('DELETE /users/@ref', 'renickbuettner\App\Users->deleteUser');
        $f3->route('DELETE /session', 'renickbuettner\App\Session->delete');

        $f3->route('GET /bridge/d', 'renickbuettner\App\DesktopClient->get');
        $f3->route('GET /statistics', 'renickbuettner\App\Statistics->get');
    }
}