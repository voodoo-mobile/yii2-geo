<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22/08/2017
 * Time: 22:34
 */

namespace vr\geo;

use yii\base\Model;

/**
 * Class Location
 * @package vr\geo
 */
class Location extends Model
{
    /**
     * @var
     */
    public $streetAddress;

    /**
     * @var
     */
    public $city;

    /**
     * @var
     */
    public $county;

    /**
     * @var
     */
    public $country;

    /**
     * @var
     */
    public $countryCode;

    /**
     * @var
     */
    public $postalCode;

    /**
     * @var
     */
    public $formatted;

    /**
     * @var
     */
    public $lat;

    /**
     * @var
     */
    public $lng;
}