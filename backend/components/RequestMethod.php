<?php
/**
 * Created by PhpStorm.
 * User: renickbuettner
 * Date: 14.12.17
 * Time: 21:39
 */

namespace renickbuettner\App;


class RequestMethod extends \SplEnum
{
    const __default = self::GET;
    const GET    = 1;
    const POST   = 2;
    const UPDATE = 3;
    const DELETE = 4;
}