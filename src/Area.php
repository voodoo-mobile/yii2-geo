<?php
/**
 * @copyright Copyright (c) 2013-2016 Voodoo Mobile Consulting Group LLC
 * @link      https://voodoo.rocks
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace vm\geo;

/**
 * Class Area
 * @package vm\geo
 */
class Area
{
    /**
     * @var
     */
    public $leftTopLat;
    /**
     * @var
     */
    public $leftTopLng;
    /**
     * @var
     */
    public $rightBottomLat;
    /**
     * @var
     */
    public $rightBottomLng;

    /**
     * Area constructor.
     *
     * @param $leftTopLat
     * @param $leftTopLng
     * @param $rightBottomLat
     * @param $rightBottomLng
     */
    public function __construct($leftTopLat, $leftTopLng, $rightBottomLat, $rightBottomLng)
    {
        $this->leftTopLat     = $leftTopLat;
        $this->leftTopLng     = $leftTopLng;
        $this->rightBottomLat = $rightBottomLat;
        $this->rightBottomLng = $rightBottomLng;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return [
            'leftTop'     => [
                'lat' => $this->leftTopLat,
                'lng' => $this->leftTopLng,
            ],
            'rightBottom' => [
                'lat' => $this->rightBottomLng,
                'lng' => $this->rightBottomLat,
            ],
        ];
    }

    /**
     * @param bool $asObject
     *
     * @return array|object
     */
    public function getLeftTop($asObject = false)
    {
        $leftTop = [
            'lat' => $this->leftTopLat,
            'lng' => $this->leftTopLng,
        ];

        if ($asObject) {
            return (object)$leftTop;
        }

        return $leftTop;
    }

    /**
     * @param bool $asObject
     *
     * @return array|object
     */
    public function getRightBottom($asObject = false)
    {
        $rightBottom = [
            'lat' => $this->rightBottomLat,
            'lng' => $this->rightBottomLng,
        ];

        if ($asObject) {
            return (object)$rightBottom;
        }

        return $rightBottom;
    }
}