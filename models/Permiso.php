<?php

namespace app\models;

use Yii;
use \app\models\base\Permiso as BasePermiso;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_item".
 */
class Permiso extends BasePermiso
{

    const TYPE = 2;
    
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
    
    public function setAttributes($values, $safeOnly = true) {
        $this->type = $this::TYPE;
        parent::setAttributes($values, $safeOnly);
    }
}
