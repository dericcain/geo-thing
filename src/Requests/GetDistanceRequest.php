<?php

namespace GeoThing\Requests;

use GeoThing\Contracts\RequestContract;
use stdClass;

class GetDistanceRequest implements RequestContract
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
     * @var array
     */
    private $response;

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
     * Return the response.
     *
     * @return stdClass
     */
    public function receive()
    {
        $this->send();

        return $this->buildResponse();
    }

    /**
     * Make the request.
     *
     * @return void
     */
    public function send()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $this->response = json_decode(curl_exec($ch), true);
    }

    /**
     * We need to build the URL string.
     *
     * @return string
     */
    private function apiUrl()
    {
        $origin = str_replace(' ', '+', urlencode($this->origin));
        $destination = str_replace(' ', '+', urlencode($this->destination));

        return "http://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins={$origin}&destinations={$destination}";
    }

    /**
     * @return mixed
     */
    private function buildResponse()
    {
        if ($this->hasErrorOrNoResults()) {
            return $this->returnErrorResponse();
        }

        return $this->returnResults();
    }

    /**
     * Check to make sure the response has results and/or is not an error.
     *
     * @return bool
     */
    private function hasErrorOrNoResults()
    {
        return $this->response['status'] != 'OK';
    }

    /**
     * When we have an error or no results, we will return that here.
     *
     * @return stdClass
     */
    private function returnErrorResponse()
    {
        $response = new stdClass;
        $response->error = $this->response['status'];
        $response->distance = null;
        $response->duration = null;

        return $response;
    }

    /**
     * We will construct the results into an object and return it.
     *
     * @return stdClass
     */
    private function returnResults()
    {
        $response = new stdClass;
        $response->distance = $this->convertMetersToMiles($this->response['rows'][0]['elements'][0]['distance']['value']) ?? null;
        $response->duration = $this->response['rows'][0]['elements'][0]['duration']['value'] ?? null;

        return $response;
    }

    /**
     * Google only gives us meters, so we need to convert them to miles.
     *
     * @param $distanceInMeters
     * @return mixed
     */
    private function convertMetersToMiles($distanceInMeters)
    {
        return $distanceInMeters * 0.000621371;
    }
}