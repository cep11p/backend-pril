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
                ['lugarid', 'compare','compareValue'=>0,'operator'=>'!=','message' => 'No se pudo registrar el Lugar correctamente en el Sistema Lugar.'],
            ]
        );
    }
    
    public function getLugar() {
        $lugar = new LugarForm();
        
        $resultado = $lugar->buscarLugarPorIdEnSistemaLugar($this->lugarid);
        
        return $resultado;
        
    }
    
    public function fields()
    {        
        $resultado = ArrayHelper::merge(parent::fields(), [
            'lugar'=> function($model){
                return $model->lugar;
            },
            'ambiente_trabajo'=> function($model){
                return $model->ambienteTrabajo->nombre;
            }
        ]);
        
        return $resultado;
    
    }
}
