<?php

namespace app\modules\backend;


class Backend extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\backend\controllers';

    public function init()
    {
        parent::init();
        \Yii::$app->language='es';
    }
}
