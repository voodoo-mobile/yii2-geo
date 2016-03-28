<?php

use yii\helpers\Url;
use \vm\geo\components\GeoLocationAsset;

/** @var bool $isLocated */
/** @var bool $toUpdate */

GeoLocationAsset::register($this);
?>

<div class="vm-geo-location" data-is-located="<?= intval($isLocated) ?>" data-to-update="<?= intval($toUpdate) ?>"
     data-url="<?= Url::to
(['/geo/coordinates/update']) ?>"></div>
