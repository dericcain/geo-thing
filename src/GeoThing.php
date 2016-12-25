<?php

namespace GeoThing;

use GeoThing\Services\GetAddress;
use GeoThing\Services\GetCoordinates;
use GeoThing\Services\GetDistance;

class GeoThing
{

    /**
     * @param $lat
     * @param $lng
     * @return \stdClass
     */
    public static function getAddress($lat, $lng)
    {
        return (new GetAddress($lat, $lng))->handle();
    }

    /**
     * @param $address
     * @param $zipCode
     * @return \stdClass
     */
    public static function getCoordinates($address, $zipCode)
    {
        return (new GetCoordinates($address, $zipCode))->handle();
    }

    /**
     * @param $origin
     * @param $destination
     * @return \stdClass
     */
    public static function getDistance($origin, $destination)
    {
        return (new GetDistance($origin, $destination))->handle();
    }
}