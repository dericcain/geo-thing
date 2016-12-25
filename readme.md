#Geo Thing
[![Build Status](https://travis-ci.org/dericcain/geo-thing.svg?branch=master)](https://travis-ci.org/dericcain/geo-thing)

- [ ] Update docs
- [x] Convert address and zip into lat and lng
- [ ] Convert lat and lng into address
- [ ] Get distance between two addresses
- [ ] Get distance between two sets of coordinates

## Usage
It's fairly simple to use the package. You will need to import that package at the top of your PHP file. Once you have done that, you can use the different methods like so:

```php
$address = '123 Main Street';
$zip = '32119';

$results = GeoThing::getCoordinates($address, $zip);
$lat = $results->lat // 33.5075002
$lng = $results->lng // -86.8105789
```
If there are no results, or there is an error, the object returned will have an `error` attribute giving the reason for the error.

```php
GeoThing::getAddress($lat, $lng);

GeoThing::getDistance($lat, $lng);

GeoThing::getDistance($address1, $address2);
```
