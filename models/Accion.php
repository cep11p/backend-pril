<?php

namespace app\models;

use Yii;
use \app\models\base\Accion as BaseAccion;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "accion".
 */
class Accion extends BaseAccion
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
