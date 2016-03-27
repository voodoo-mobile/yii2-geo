# yii2-geo
## GeoLocation widget

**Configs:**
```
    'modules'      => [
        'geo' => [
            'class' => 'vm\geo\module\Module'
        ]
    ],

```

**View file:**
```
    echo GeoLocationWidget::widget()
```

**Getting coordinates (in model or controller):**
```
  $lat = Yii::$app->session->get('coordinates.lat');
  $lng = Yii::$app->session->get('coordinates.lng');
```

**Also you can check geolocation status**
```
  Yii::$app->session->get('coordinates.isLocated');
```
Will return 1 if already located
