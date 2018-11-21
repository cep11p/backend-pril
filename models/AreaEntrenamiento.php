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
            'plan'=> function($model){
                return $model->plan->monto;
            },
            'ambiente_trabajo'=> function($model){
                return $model->oferta->ambienteTrabajo->nombre;
            },
            'destinatario'=> function($model){
                return $model->destinatario->persona['nombre'];
            }
        ]);
        
        return $resultado;
    
    }
}
