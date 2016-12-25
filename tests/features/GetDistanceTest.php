<?php

namespace features;

use GeoThing\GeoThing;

class GetDistanceTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function given_2_addresses_a_distance_is_returned()
    {
        $address1 = '1401 1st Ave S, Birmingham, AL 35233';
        $address2 = '1200 4th Ave N, Birmingham, AL 35203';

        $response = GeoThing::getDistance($address1, $address2);

        $distance = $this->parseNumberFromString($response->distance);

        $this->assertLessThan(2, $distance);
    }

    /**
     * @param $distance
     * @return float
     */
    private function parseNumberFromString($distance)
    {
        return (float) explode(' ', $distance)[0];
    }
}
