<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22/08/2017
 * Time: 22:31
 */

namespace vr\geo;

use dosamigos\google\maps\LatLng;
use stdClass;
use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class Geo
 * @package vr\geo
 */
class Geo extends Component
{
    /**
     * @var
     */
    public $apiKey;

    /**
     * @param $address
     *
     * @return null|Location
     */
    public function geocode($address)
    {

        $client = new GeocodingClient();

        $result = $client->lookup([
            'address' => $address,
            'key'     => $this->apiKey,
        ]);

        if ($result->status != 'OK') {
            return null;
        }

        return $this->getLocation($result);
    }

    /**
     * @param $result
     *
     * @return Location
     */
    protected function getLocation($result): Location
    {
        $result = reset($result->results);

        /** @var stdClass $long */
        $long = (object)ArrayHelper::map($result->address_components,
            function ($component) { return reset($component->types); },
            function ($component) { return $component->long_name; }
        );

        /** @var stdClass $short */
        $short = (object)ArrayHelper::map($result->address_components,
            function ($component) { return reset($component->types); },
            function ($component) { return $component->short_name; }
        );

        $streetAddress = trim(implode(' ', array_filter([
            @$short->street_number,
            @$short->route,
        ])));

        $location = new Location([
            'streetAddress' => $streetAddress,
            'city'          => @$short->postal_town ?: @$short->locality,
            'country'       => $long->country,
            'countryCode'   => $short->country,
            'county'        => @$short->administrative_area_level_1,
            'postalCode'    => @$short->postal_code,
            'formatted'     => $result->formatted_address,
            'lat'           => $result->geometry->location->lat,
            'lng'           => $result->geometry->location->lng,
        ]);

        return $location;
    }

    /**
     * @param $lat
     * @param $lng
     *
     * @return null|Location
     * @throws \Exception
     */
    public function reverse($lat, $lng)
    {
        $client = new GeocodingClient();

        $result = $client->reverse(new LatLng([
            'lat' => $lat,
            'lng' => $lng,
        ]), [
            'key' => $this->apiKey,
        ]);

        if ($result->status != 'OK') {
            return null;
        }

        return $this->getLocation($result);
    }
}