<?php

namespace app\models;

use Yii;
use \app\models\base\AreaEntrenamiento as BaseAreaEntrenamiento;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "area_entrenamiento".
 */
class AreaEntrenamiento extends BaseAreaEntrenamiento
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
            'plan_nombre'=> function($model){
                return $model->plan->nombre;
            },
            'plan_monto'=> function($model){
                return $model->plan->monto;
            },
            'plan_hora_semanal'=> function($model){
                return $model->plan->hora_semanal;
            },
        ]);
        
        return $resultado;
    
    }
}
