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
                ['destinatarioid', 'validarDestinatario'],
            ]
        );
    }
    
    public function validarDestinatario() {
        if($this->destinatario->personaid == $this->oferta->ambienteTrabajo->personaid ){
            $this->addError('destintarioid', 'El destinatario no puede ser la misma persona que representa al ambiente de trabjo.');
        }
        
        $coleccion_area_entrenamiento = $this->destinatario->areaEntrenamientos;
        foreach ($coleccion_area_entrenamiento as $area) {
            if($area->fecha_final > date('Y-m-d')){
                $this->addError('destinatarioid','El destinatario se encuentra en una area de entrenamiento todavía vigente.');
                break;
            }            
        }
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
