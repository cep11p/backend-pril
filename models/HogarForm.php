<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "persona".
 */
class HogarForm extends Model
{
    public $id;
    public $lugarid;
    public $jefeid;

    public function rules()
    {
        return [
            [['lugarid'], 'required'],
            [['jefeid','lugarid','id'], 'integer']
        ];
    }
    
    /**
     * Devolvemos el hogar encontrado
     * @return array
     */
    public function buscarHogarEnSistemaRegistral(){        
        $resultado = null;
        $response = \Yii::$app->registral->buscarHogar($this->attributes);   
        if(isset($response['success']) && $response['success']==true){

            if(count($response['resultado'])>0){            
                $resultado = $response['resultado'][0];
            }
        }
        
        return $resultado;
    }
    
    
   
}
