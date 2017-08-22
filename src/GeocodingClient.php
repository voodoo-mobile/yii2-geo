<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23/08/2017
 * Time: 00:24
 */

namespace vr\geo;

use dosamigos\google\maps\LatLng;
use yii\helpers\ArrayHelper;

class GeocodingClient extends \dosamigos\google\maps\services\GeocodingClient
{
    /**
     * Makes a reverse geocoding
     *
     * @param LatLng $coord
     * @param array  $params parameters for the request. These override [GeocodingRequest::params].
     *
     * @return mixed|null
     */
    public function reverse(LatLng $coord, $params = [])
    {
        $params['latlng'] = $coord->__toString();

        $this->params = ArrayHelper::merge($this->params, $params);

        return parent::request();
    }
}