<?php

namespace GeoThing\Requests;

use GeoThing\Contracts\RequestContract;
use stdClass;

class GetAddressRequest implements RequestContract
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
     * @var array
     */
    private $response;

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
        $encodedQuery = urlencode($this->lat . ',' . $this->lng);

        return "http://maps.googleapis.com/maps/api/geocode/json?latlng={$encodedQuery}";
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
        $response->street_number = null;
        $response->street_name = null;
        $response->city = null;
        $response->state = null;
        $response->zip = null;
        $response->formatted_address = null;

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
        $response->street_number = $this->response['results'][0]['address_components'][0]['long_name'] ?? null;
        $response->street_name = $this->response['results'][0]['address_components'][1]['long_name'] ?? null;
        $response->city = $this->response['results'][0]['address_components'][3]['long_name'] ?? null;
        $response->state = $this->response['results'][0]['address_components'][5]['long_name'] ?? null;
        $response->zip = $this->response['results'][0]['address_components'][7]['long_name'] ?? null;
        $response->formatted_address = $this->response['results'][0]['formatted_address'] ?? null;

        return $response;
    }
}