<?php

namespace GeoThing\Services;

class GetAddress
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @param $address
     * @param $zipCode
     */
    public function __construct($address, $zipCode)
    {
        $this->address = $address;
        $this->zipCode = $zipCode;
    }

    /**
     * @return array|null
     */
    public function handle()
    {
        return $this->getCoordinates();
    }

    /**
     * @return array|null
     */
    private function getCoordinates()
    {
        $response = $this->makeApiCall();

        return [
            'lat' => $response['location']['lat'] ?? null,
            'lng' => $response['location']['lng'] ?? null,
        ];
    }

    /**
     * @return string
     */
    private function apiUrl()
    {
        $encodedQuery = str_replace (' ', '+', urlencode($this->address . ' ' . $this->zipCode));

        return "http://maps.googleapis.com/maps/api/geocode/json?address={$encodedQuery}&sensor=false";
    }

    /**
     * @return mixed
     */
    private function makeApiCall()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);

        // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
        if ($response['status'] != 'OK') {
            return null;
        }

        return $response['results'][0]['geometry'];
    }
}