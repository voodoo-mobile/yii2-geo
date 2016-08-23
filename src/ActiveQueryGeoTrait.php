<?php

namespace vm\geo;

/**
 * Class ActiveQueryRandomTrait
 * @package vm\core
 */
trait ActiveQueryGeoTrait
{
    /**
     * @param float $lat
     * @param float $lng
     *
     * @return mixed
     */
    public function orderByNearby($lat, $lng)
    {
        return $this->select('*, DEGREES(ACOS(COS(RADIANS(lat)) * COS(RADIANS(:lat2)) *
             COS(RADIANS(lng) - RADIANS(:lng2)) +
             SIN(RADIANS(lat)) * SIN(RADIANS(:lat2)))) * :unit_in_degree as distance')->addParams([
            'lat2' => $lat,
            'lng2' => $lng,
            'unit_in_degree' => Coordinates::KM_AT_DEGREE
        ])->orderBy('distance');
    }

    /**
     * @param $lat
     * @param $lng
     * @param $radius
     *
     * Radius must be in miles
     */
    public function inRadius($lat, $lng, $radius)
    {
        return $this->andWhere('DEGREES(ACOS(COS(RADIANS(lat)) * COS(RADIANS(:lat2)) *
             COS(RADIANS(lng) - RADIANS(:lng2)) +
             SIN(RADIANS(lat)) * SIN(RADIANS(:lat2)))) * :unit_in_degree < :radius',
            [
                'lat2'   => $lat,
                'lng2'   => $lng,
                'radius' => $radius,
                'unit_in_degree'  => Coordinates::KM_AT_DEGREE
            ]
        );
    }
}