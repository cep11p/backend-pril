<?php

namespace app\models;

use Yii;
use \app\models\base\Profesion as BaseProfesion;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "profesion".
 */
class Profesion extends BaseProfesion
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
