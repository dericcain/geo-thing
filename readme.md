#Geo Thing
[![Build Status](https://travis-ci.org/dericcain/geo-thing.svg?branch=master)](https://travis-ci.org/dericcain/geo-thing)

## Description
This is a very simple package that uses Google's API to perform a few different operations. As a default, you do not have to supply an API key but you will be limited with how many API requests you can make. If you are not making a ton of calls, this should be good enough.

## Usage
It's fairly simple to use the package. You will need to import that package at the top of your PHP file. Once you have done that, you can use the different methods below.

#### Get Coordinates from Address
```php
$address = '123 Main Street';
$zip = '32119';

$results = GeoThing::getCoordinates($address, $zip);

$results->lat // 33.5075002
$results->lng // -86.8105789
$results->error // The error code from Google if there is one. This attribute will not be here if there is not error.
```
If there are no results, or there is an error, the object returned will have an `error` attribute giving the reason for the error. Also, the `lat` and `lng` attributes will be set to `null`.

#### Get Address from Coordinates
```php
$response = GeoThing::getAddress($lat, $lng);

$response->error // This will only be set if there is an error
$response->street_number // The number only
$response->street_name // The name of the street
$response->city // The full city name
$response->state // The full state name, not the abbreviation
$response->zip // The zip code
$response->formatted_address // The full formated address "277 Bedford Avenue, Brooklyn, NY 11211, USA"
```

#### Get Distance between Origin and Destination
```php
$response = GeoThing::getDistance($origin, $destination);

$response->error // This will only be set if there is an error
$response->distance // This will be a string like "1.2 mi" (I'll change this soon)
$response->duration // This will also be a string as of right now
```

## TODO
- [ ] Get distance between two sets of coordinates
- [ ] Convert test endpoints into mocks instead of using the live API
- [ ] Add option to user API key
- [ ] Add KM to distance as an option
