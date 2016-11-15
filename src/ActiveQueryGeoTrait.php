<?php

namespace vr\geo;

/**
 * Class ActiveQueryRandomTrait
 * @package vr\core
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
        /** @var ActiveQuery $this */
        return $this
            ->select('*, DEGREES(ACOS(COS(RADIANS(lat)) * COS(RADIANS(:lat)) *
             COS(RADIANS(lng) - RADIANS(:lng)) +
             SIN(RADIANS(lat)) * SIN(RADIANS(:lat)))) * :unit_in_degree as distance')
            ->addParams([
                ':lat'           => $lat,
                ':lng'           => $lng,
                'unit_in_degree' => Coordinates::KM_AT_DEGREE,
            ])->orderBy('distance');
    }

    /**
     * @param $lat
     * @param $lng
     * @param $radius
     * Radius must be in miles
     */
    public function inRadius($lat, $lng, $radius)
    {
        /** @var ActiveQuery $this */
        return $this->andWhere('DEGREES(ACOS(COS(RADIANS(lat)) * COS(RADIANS(:lat)) *
             COS(RADIANS(lng) - RADIANS(:lng)) +
             SIN(RADIANS(lat)) * SIN(RADIANS(:lat)))) * :unit_in_degree < :radius',
            [
                ':lat'            => $lat,
                ':lng'            => $lng,
                ':radius'         => $radius,
                ':unit_in_degree' => Coordinates::KM_AT_DEGREE,
            ]
        );
    }
}