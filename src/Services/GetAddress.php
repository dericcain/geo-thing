<?php

namespace GeoThing\Services;

use GeoThing\Contracts\ServicesContract;
use GeoThing\Requests\GetAddressRequest;

class GetAddress implements ServicesContract
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
        $request = new GetAddressRequest($this->lat, $this->lng);

        return $request->receive();
    }
}