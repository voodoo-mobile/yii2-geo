<?php

namespace vm\geo\module\controllers;

use yii\web\BadRequestHttpException;
use yii\web\Controller;

class CoordinatesController extends Controller
{
    public function actionUpdate()
    {
        if (!\Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }

        $lat = \Yii::$app->request->post('lat');
        $lng = \Yii::$app->request->post('lng');

        if (!$lat || !$lng) {
            throw new BadRequestHttpException();
        }

        \Yii::$app->session->set('coordinates.lat', $lat);
        \Yii::$app->session->set('coordinates.lng', $lng);
        \Yii::$app->session->set('coordinates.isLocated', 1);

        return true;
    }
}