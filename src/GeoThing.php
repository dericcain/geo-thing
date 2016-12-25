<?php

namespace GeoThing;

use GeoThing\Services\GetAddress;
use GeoThing\Services\GetCoordinates;
use GeoThing\Services\GetDistance;

class GeoThing
{

    /**
     * @param $address
     * @param $zipCode
     * @return array|null
     */
    public static function getAddress($address, $zipCode)
    {
        return (new GetAddress($address, $zipCode))->handle();
    }

    /**
     * @param $lat
     * @param $lng
     * @return \stdClass
     */
    public static function getCoordinates($lat, $lng)
    {
        return (new GetCoordinates($lat, $lng))->handle();
    }

    /**
     * @param $param1
     * @param $param2
     * @return bool
     */
    public static function getDistance($param1, $param2)
    {
        return (new GetDistance($param1, $param2))->handle();
    }
}