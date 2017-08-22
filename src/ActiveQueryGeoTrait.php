<?php

namespace vr\geo;

use yii\db\ActiveQuery;

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
    public function orderByDistance($lat, $lng)
    {
        /** @var ActiveQuery $this */
        return $this
            ->select('*, DEGREES(ACOS(COS(RADIANS(lat)) * COS(RADIANS(:lat)) *
             COS(RADIANS(lng) - RADIANS(:lng)) +
             SIN(RADIANS(lat)) * SIN(RADIANS(:lat)))) as distance')
            ->addParams([
                ':lat' => $lat,
                ':lng' => $lng,
            ])->orderBy('distance');
    }

    /**
     * @param float $lat
     * @param float $lng
     * @param float $radius . The radius that describes an area in kilometers
     *
     * @return $this
     */
    public function around(float $lat, float $lng, float $radius)
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