<?php

namespace app\models;

use Yii;
use \app\models\base\Oferta as BaseOferta;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "oferta".
 */
class Oferta extends BaseOferta
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
    
    public function fields()
    {        
        $resultado = ArrayHelper::merge(parent::fields(), [
            'lugar'=> function($model){
                return "un lugar";
            }
        ]);
        
        return $resultado;
    
    }
}
