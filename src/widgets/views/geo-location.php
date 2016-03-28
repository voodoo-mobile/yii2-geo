<?php

use yii\helpers\Url;
use \vm\geo\components\GeoLocationAsset;

/** @var bool $isLocated */
/** @var bool $toUpdate */
/** @var float $lat */
/** @var float $lng */

GeoLocationAsset::register($this);
?>

<div class="vm-geo-location"
     data-is-located="<?= intval($isLocated) ?>"
     data-to-update="<?= intval($toUpdate) ?>"
     data-lat="<?= $lat ?>"
     data-lng="<?= $lng ?>"
     data-url="<?= Url::to(['/geo/coordinates/update']) ?>">
</div>
