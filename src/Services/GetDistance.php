<?php

namespace GeoThing\Services;

use GeoThing\Contracts\ServicesContract;
use GeoThing\Requests\GetDistanceRequest;

class GetDistance implements ServicesContract
{

    /**
     * @var string
     */
    private $origin;

    /**
     * @var string
     */
    private $destination;

    /**
     * @param $origin
     * @param $destination
     */
    public function __construct($origin, $destination)
    {
        $this->origin = $origin;
        $this->destination = $destination;
    }

    /**
     * @return \stdClass
     */
    public function handle()
    {
        $request = new GetDistanceRequest($this->origin, $this->destination);

        return $request->receive();
    }
}