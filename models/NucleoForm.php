<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "persona".
 */
class NucleoForm extends Model
{
    public $id;
    public $nombre;
    public $hogarid;
    public $jefeid;

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['jefeid', 'hogarid'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            ['id','existeNucleoEnSistemaRegistral']
        ];
    }
    
    public function existeNucleoEnSistemaRegistral(){
        $resultado = null;
        $response = \Yii::$app->registral->buscarNucleoPorId($this->id);
        
        if(isset($response['success']) && $response['success']==true){

            if(count($response['resultado'])==0){            
                $this->addError("id","El nucleo con el id $this->id no existe!");
            }
        }
    }

        /**
     * Se busca un nucleo usando un criterio de busquedad que es armado mediantes los atributos recibido de $param
     * @param array $param son atributos asociativos relevante a la busquedad
     * @return string
     */
    public function buscarNucleoEnSistemaRegistral($param) {
        
        $resultado = null;
        $response = \Yii::$app->registral->buscarNucleo($param);
        
        if(isset($response['success']) && $response['success']==true){

            if(count($response['resultado'])>0){            
                foreach ($response['resultado'] as $modeloEncontrado){
                    $resultado = $modeloEncontrado;
                }
            }
        }
        
        return $resultado;
    }
    
    
    
   
}
