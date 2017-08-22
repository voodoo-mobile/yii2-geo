<?php

/**
 * @copyright Copyright (c) 2013-2016 Voodoo Rocks Ltd
 * @link      https://voodoo.rocks
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace vr\geo;

use yii\base\Component;

/**
 * How to use:
 * 1. You can create an object of this type like
 *     $coordinates = new Coordinates();
 *     $coordinates->distance(...)
 * 2. Make it Yii2 way:
 *     a) add following lines to config/web.php
 *         ...
 *         'coordinates' => [
 *             'class' => '\vr\geo\Coordinates',
 *         ]
 *     b) use it everywhere you need this way
 *         \Yii::$app->get('coordinates')->distance(...)
 * -------------------------------------------------------
 * Class Coordinates
 * @package vr\geo
 */
class Coordinates extends Component
{
    /**
     *
     */
    const METERS_PER_DEGREE_LATITUDE = 11132.22;
    /**
     *
     */
    const EARTH_PERIMETER_METERS = 40076000;
    /**
     *
     */
    const EARTH_RADIUS_METERS = 6378293;
    /**
     *
     */
    const TOTAL_DEGREES = 360;

    /**
     * HALF_OF_EARTH_CIRCUMFERENCE_IN_PIXEL / pi()
     */
    const EARTH_RADIUS_PIXELS = 85445659.447;

    /**
     * at zoom level 21
     */
    const HALF_OF_EARTH_CIRCUMFERENCE_IN_PIXELS = 268435456;

    /**
     *
     */
    const MILES_AT_DEGREE = 63;

    /**
     *
     */
    const MILES_TO_METERS_DIVIDER = 0.62137;

    /**
     *
     */
    const KM_AT_DEGREE = 101.388866;

    /**
     * @param $meters
     *
     * @return float
     */
    public function metersToDegrees($meters)
    {
        return $meters / self::EARTH_PERIMETER_METERS * self::TOTAL_DEGREES;
    }

    /**
     * @param $degrees
     *
     * @return float
     */
    public function degreesToMeters($degrees)
    {
        return $degrees / self::TOTAL_DEGREES * self::EARTH_PERIMETER_METERS;
    }

    /**
     * @param     $lat
     * @param int $width
     * @param int $height
     *
     * @return float
     */
    public function latToMercatorY($lat,
        $width = self::HALF_OF_EARTH_CIRCUMFERENCE_IN_PIXELS,
        $height = self::HALF_OF_EARTH_CIRCUMFERENCE_IN_PIXELS)
    {
        return ($height / 2) - ($width * log(tan((M_PI / 4) + (($lat * M_PI / 180) / 2))) / (2 * M_PI));
    }

    /**
     * @param     $lng
     * @param int $width
     *
     * @return mixed
     */
    public function lngToMercatorX($lng,
        $width = self::HALF_OF_EARTH_CIRCUMFERENCE_IN_PIXELS)
    {
        return ($lng + 180) * ($width / 360);
    }

    /**
     * @param $lat1
     * @param $lng1
     * @param $lat2
     * @param $lng2
     *
     * @return float
     */
    public function surfaceDistance($lat1, $lng1, $lat2, $lng2)
    {
        $x1 = self::lngToX($lng1);
        $y1 = self::latToY($lat1);

        $x2 = self::lngToX($lng2);
        $y2 = self::latToY($lat2);

        return sqrt(pow(($x1 - $x2), 2) + pow(($y1 - $y2), 2));
    }

    /**
     * @param $lng
     *
     * @return float
     */
    public function lngToX($lng)
    {
        return round(self::HALF_OF_EARTH_CIRCUMFERENCE_IN_PIXELS + self::EARTH_RADIUS_PIXELS * $lng * pi() / 180);
    }

    /**
     * @param $lat
     *
     * @return float
     */
    public function latToY($lat)
    {
        return round(self::HALF_OF_EARTH_CIRCUMFERENCE_IN_PIXELS - self::EARTH_RADIUS_PIXELS *
                                                                   log((1 + sin($lat * pi() / 180)) /
                                                                       (1 - sin($lat * pi() / 180))) / 2);
    }

    /**
     * @param $lat1
     * @param $lng1
     * @param $lat2
     * @param $lng2
     *
     * @return float
     */
    public function distance($lat1, $lng1, $lat2, $lng2)
    {
        $latd = deg2rad($lat2 - $lat1);
        $lngd = deg2rad($lng2 - $lng1);
        $a    = sin($latd / 2) * sin($latd / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($lngd / 2) * sin($lngd / 2);
        $c    = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS_METERS * $c / 1000;
    }
}