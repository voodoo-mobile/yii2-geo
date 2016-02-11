<?php
/**
 * @copyright Copyright (c) 2013-2016 Voodoo Mobile Consulting Group LLC
 * @link      https://voodoo.rocks
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace vm\geo;

use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * Class Cluster
 * @package vm\geo
 */
class Cluster
{

    /**
     *
     */
    const DISTANCE_FOR_GROUP = 0.02;

    /**
     * @param $item
     *
     * @throws Exception
     */
    protected static function checkItem($item)
    {
        if (!ArrayHelper::keyExists('lat', $item) || !ArrayHelper::keyExists('lat', $item)) {

            throw new Exception('Items should have \'lat\' and \'lng\' properties');
        }
    }

    /**
     * @param $item
     * @param $countCallback
     *
     * @return int|mixed
     */
    protected static function getCount($item, $countCallback)
    {
        if (!$countCallback) {
            return 1;
        }

        return call_user_func($countCallback, $item);
    }

    /**
     * @param $item
     * @param $attributesCallback
     *
     * @return mixed
     */
    protected static function getAttributes($item, $attributesCallback)
    {
        if (!$attributesCallback) {
            return $item;
        }

        return call_user_func($attributesCallback, $item);
    }

    /**
     * @param Area $area
     * @param      $distanceForGroup
     *
     * @return float
     */
    protected static function getPixelDistanceForGroup(Area $area, $distanceForGroup)
    {
        $pixels = Coordinates::pixelDistance(
            $area->leftTopLat,
            $area->leftTopLng,
            $area->rightBottomLat,
            $area->rightBottomLng
        );

        return $pixels * $distanceForGroup;
    }

    /**
     * @param array    $items
     * @param Area     $area
     * @param callable $countCallback
     * @param callable $attributesCallback
     * @param          $distanceForGroup //Part of area diagonal
     *
     * @return array
     * @throws Exception
     * Response format:
     * [
     *     [
     *         'count' => n,
     *         'lat' => '0.123'
     *         'lng' => '-0.123'
     *         'attributes' => []
     *     ],
     *     [
     *          ...
     *     ],
     *     ...
     * ]

     */
    public static function cluster(
        array $items,
        Area $area,
        callable $countCallback = null,
        callable $attributesCallback = null,
        $distanceForGroup = self::DISTANCE_FOR_GROUP)
    {

        $pixelDistanceForGroup = self::getPixelDistanceForGroup($area, $distanceForGroup);
        $clusters              = [];

        while (count($items)) {

            $item = array_pop($items);

            self::checkItem($item);
            $cluster = [
                'count'      => 0,
                'attributes' => [],
            ];

            foreach ($items as $key => $targetItem) {

                self::checkItem($targetItem);

                $pixels = Coordinates::pixelDistance(
                    ArrayHelper::getValue($item, 'lat'),
                    ArrayHelper::getValue($item, 'lng'),
                    ArrayHelper::getValue($targetItem, 'lat'),
                    ArrayHelper::getValue($targetItem, 'lng')
                );

                if ($pixelDistanceForGroup > $pixels) {
                    $cluster['count'] += self::getCount($targetItem, $countCallback);
                    unset($items[$key]);
                }
            }

            if ($cluster['count'] == 0) {
                $cluster['attributes'] = self::getAttributes($item, $attributesCallback);
            }
            $cluster['count'] += self::getCount($item, $countCallback);
            $cluster['lat'] = ArrayHelper::getValue($item, 'lat');
            $cluster['lng'] = ArrayHelper::getValue($item, 'lng');

            $clusters[] = $cluster;
        }

        return $clusters;
    }
}