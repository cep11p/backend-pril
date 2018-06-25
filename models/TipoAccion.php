<?php

namespace app\models;

use Yii;
use \app\models\base\TipoAccion as BaseTipoAccion;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tipo_accion".
 */
class TipoAccion extends BaseTipoAccion
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
