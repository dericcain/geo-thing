#Geo Thing
[![Build Status](https://travis-ci.org/dericcain/geo-thing.svg?branch=master)](https://travis-ci.org/dericcain/geo-thing)

- [ ] Convert address and zip into lat and lng
- [ ] Convert lat and lng into address
- [ ] Get distance between two addresses
- [ ] Get distance between two sets of coordinates

```php
GeoThing::getAddress($lat, $lng);
GeoThing::getCoordinates($address, $zip);
GeoThing::getDistance($lat, $lng);
GeoThing::getDistance($address1, $address2);
```
