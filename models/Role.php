<?php

namespace app\models;

use Yii;
use \app\models\base\Role as BaseRole;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_item".
 */
class Role extends BaseRole
{
    /**
     * @var INT Es el tipo de auth_item, en este caso el tipo es 1 = Role
     */
    const TYPE = 1;

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
