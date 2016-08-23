<?php

namespace vm\geo\widgets;
use yii\base\Widget;

class GeoLocationWidget extends Widget
{
    public $updatePageAfter = true;

    public function run()
    {
        $isLocated = \Yii::$app->session->get('coordinates.isLocated');

        return $this->render('geo-location', [
            'isLocated' => $isLocated,
            'toUpdate' => $this->updatePageAfter,
            'lat' => \Yii::$app->session->get('coordinates.lat'),
            'lng' => \Yii::$app->session->get('coordinates.lng'),
        ]);
    }
}