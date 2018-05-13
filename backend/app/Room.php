<?php
/**
 * Kommunikationsobjekt: Room
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 06.01.18
 * Time: 20:23
 */

namespace renickbuettner\App;


class Room
{

    public  $uuid,
            $name,
            $location;

    private $reservations;

    /**
     * Room constructor.
     * @param $name
     * @param $location
     * @param null $uuid
     * Erstellt eine neue Instanz,
     * ist die UUID null, wird beim speichern
     * per Zufallsgenerator eine erstellt.
     */
    public function __construct($name, $location, $uuid = null)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->location = $location;
    }

    /**
     * @param $f3
     * Speichert das Objekt über die globale Instanz
     * des Frameworks in der Datenbank.
     * Dabei wird mit der Datenbank-Abstraktions-Layer
     * gearbeitet.
     */
    public function save($f3)
    {
        try {
            $con  = $f3->get("Database");
            $tmp = $con->writeRoom($this);
            if($this->uuid == null)
                $this->uuid = $tmp;
            unset($tmp);
        } catch (\Exception $e){}
    }

    /**
     * @param $f3
     * Entfernt über die globale Instanz des
     * Frameworks einen Raum aus der Datenbank.
     * Dabei wird mit der Datenbank-Abstraktions-Layer
     * gearbeitet.
     */
    public function remove($f3)
    {
        try {
            $con = $f3->get("Database");
            $con->removeRoom($this);
        } catch (\Exception $e){}
    }

    /**
     * @return array
     * Wandelt die Klasse in ein Array um,
     * welches weitergegeben werden kann.
     * Aufbau orientiert sich am Kommunikationsobjekt.
     */
    public function toArray()
    {
        return [
            "uuid" => $this->uuid,
            "name" => $this->name,
            "location" => $this->location,
            "reservations" => [
                "href" => "/rooms/".$this->uuid."/reservations"]];
    }

}