<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 06.01.18
 * Time: 20:06
 */

namespace renickbuettner\App;


class Statistics
{

    public function __construct()
    {
        $cache = \Cache::instance();
        if(!$cache->exists('stats'))
            $cache->set('stats', $this->collection(),43200);
    }

    public function get()
    {

    }

    private function collection()
    {
        return [
            "linesOfCode"   => [
                "frontend" => null,
                "backend"  => null
            ],
            "commits" => null,
            "storedData" => null
        ];
    }


}