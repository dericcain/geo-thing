<?php

namespace GeoThing\Services;

use GeoThing\Contracts\ServicesContract;
use GeoThing\Requests\GetCoordinatesRequest;

class GetCoordinates implements ServicesContract
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $zip;

    /**
     * @param $address
     * @param $zip
     */
    public function __construct($address, $zip)
    {
        $this->address = $address;
        $this->zip = $zip;
    }

    /**
     * @return \stdClass
     */
    public function handle()
    {
        $request = new GetCoordinatesRequest($this->address, $this->zip);

        return $request->receive();
    }
}