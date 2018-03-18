# ISS Position

Simple application obtaining information about current position of ISS from [https://wheretheiss.at/](https://wheretheiss.at/).

Position of ISS is additionally reverse geocoded with Google Maps API to display human readable format.

Position is also displayed on the map.

![](screenshot.png)

## Install and run application
Fastest way of running application is using built-in PHP server:
```bash
git clone git@github.com:mhyndle/iss-position.git

# install composer dependencies
cd iss-position
composer install

# run built-in PHP server inside `public` folder
cd public
php -S localhost:8000
``` 
Application will be available at [http://localhost:8000](http://localhost:8000)

## Development
