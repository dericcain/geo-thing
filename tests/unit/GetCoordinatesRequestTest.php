<?php

use GeoThing\Requests\GetCoordinatesRequest;

class GetCoordinatesRequestTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    function a_request_made_to_google_should_return_a_200_status()
    {
        $address = '1401 1st Ave S';
        $zip = '35233';
        $request = new GetCoordinatesRequest($address, $zip);

        $this->assertInstanceOf(stdClass::class, $request->receive());
        $this->assertObjectHasAttribute('lat', $request->receive());
        $this->assertObjectHasAttribute('lng', $request->receive());
        $this->assertObjectNotHasAttribute('error', $request->receive());
    }

    /** @test */
    function an_error_attribute_is_returned_when_there_are_no_results()
    {
        $address = '12345678 Mainers Street';
        $zip = '12345';
        $request = new GetCoordinatesRequest($address, $zip);

        $this->assertInstanceOf(stdClass::class, $request->receive());
        $this->assertNull($request->receive()->lat);
        $this->assertNull($request->receive()->lng);
        $this->assertObjectHasAttribute('error', $request->receive());
    }
}
