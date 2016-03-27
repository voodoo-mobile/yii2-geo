<?php

namespace vm\geo\widgets;
use yii\base\Widget;

class GeoLocationWidget extends Widget
{
    public function run()
    {
        $isLocated = \Yii::$app->session->get('coordinates.isLocated');

        return $this->render('geo-location', ['isLocated' => $isLocated]);
    }
}