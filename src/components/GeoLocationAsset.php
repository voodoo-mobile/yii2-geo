<?php

namespace vm\geo\components;

use yii\web\AssetBundle;

class GeoLocationAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/vendor/voodoo-mobile/yii2-geo/src/assets';

    /**
     * @var string
     */
    public $baseUrl = '@web';

    public $js = [
        'js/vm-geo-location'
    ];
}