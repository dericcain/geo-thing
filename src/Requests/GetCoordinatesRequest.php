<?php

namespace GeoThing\Requests;

use GeoThing\Contracts\RequestContract;
use stdClass;

class GetCoordinatesRequest implements RequestContract
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
     * @var array
     */
    private $response;

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
        $encodedQuery = str_replace(' ', '+', urlencode($this->address . ' ' . $this->zip));

        return "http://maps.googleapis.com/maps/api/geocode/json?address={$encodedQuery}&sensor=false";
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
        $response->lat = null;
        $response->lng = null;

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
        $response->lat = $this->response['results'][0]['geometry']['location']['lat'] ?? null;
        $response->lng = $this->response['results'][0]['geometry']['location']['lng'] ?? null;

        return $response;
    }
}