<?php

namespace GeoThing\Services;

use GeoThing\Requests\GetAddressRequest;

class GetAddress
{
    /**
     * @var string
     */
    private $lat;

    /**
     * @var string
     */
    private $lng;

    /**
     * @param $lat
     * @param $lng
     */
    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    /**
     * @return \stdClass
     */
    public function handle()
    {
        return $this->makeApiCall();
    }

    /**
     * @return \stdClass
     */
    private function makeApiCall()
    {
        $request = new GetAddressRequest($this->lat, $this->lng);

        return $request->receive();
    }
}