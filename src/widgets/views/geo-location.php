<?php

use yii\helpers\Url;
use \vm\geo\components\GeoLocationAsset;

/** @var bool $isLocated */

GeoLocationAsset::register($this);
?>

<div class="vm-geo-location" data-is-located="<?= intval($isLocated) ?>" data-url="<?= Url::to(['/geo/coordinates/update']) ?>"></div>
