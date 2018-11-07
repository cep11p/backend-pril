<?php

namespace app\models;

use Yii;
use \app\models\base\AmbienteTrabajo as BaseAmbienteTrabajo;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ambiente_trabajo".
 */
class AmbienteTrabajo extends BaseAmbienteTrabajo
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
//                ['lugarid', 'existeLugarEnSistemaLugar','skipOnEmpty' => true],
            ]
        );
    }
    
    public function getLugar() {
        $lugar = new LugarForm();
        
        $resultado = $lugar->buscarLugarPorIdEnSistemaLugar($this->lugarid);
        
        return $resultado;
        
    }
    
    /** para obtener este dato se requiere hacer una interoperabilidad con el sistema Registral**/
    public function getPersona(){
        $resultado = null;
        $model = new PersonaForm();
        $arrayPersona = $model->obtenerPersonaConLugarYEstudios($this->personaid);

        if($arrayPersona){
            $resultado = $arrayPersona;
        }        
        unset($resultado['lugar']);
        
        return $resultado;
        
        
    }
    
    public function fields()
    {        
        $resultado = ArrayHelper::merge(parent::fields(), [
            'persona'=> function($model){
                return $model->persona;
            },
            'lugar'=> function($model){
                return $model->lugar;
            }
        ]);
        
        return $resultado;
    
    }
}
