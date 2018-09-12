<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "persona".
 */
class LugarForm extends Model
{
    public $id;
    public $nombre;
    public $calle;
    public $altura;
    public $localidadid;
    public $latitud;
    public $longitud;
    public $barrio;
    public $piso;
    public $depto;
    public $escalera;

    public function rules()
    {
        return [
            [['calle', 'altura', 'localidadid'], 'required'],
            [['localidadid','id'], 'integer'],
            [['nombre', 'calle', 'altura', 'latitud', 'longitud', 'barrio', 'piso', 'depto', 'escalera'], 'string', 'max' => 200],
            ['localidadid','existeLocalidadEnSistemaLugar'],
//            ['localidadid','existeLugar'],//aprovechamos que localidadid es obligatorio, para realizar siempre una busquedad de lugar
        ];
    }
    
    public function existeLocalidadEnSistemaLugar() {
        $response = \Yii::$app->lugar->buscarLocalidadPorId($this->localidadid);       
        
        if(isset($response['success']) && $response['success']!=true){
            $this->addError('id', 'La localidad con el id '.$this->id.' no existe!');
        }
    }
    
    /**
     * Vamos a verificar si existe, si existe, se notificará y se enviara el id del lugar con el fin de ser utilizado si se quiere
     */
    public function existeLugar(){
        $response = \Yii::$app->lugar->buscarLugar($this->attributes);       
        
        if(isset($response['success']) && $response['success']==true){
            
            if(count($response['resultado'])>0){            
                foreach ($response['resultado'] as $modeloEncontrado){
                    $lugar["id"]=$modeloEncontrado['id'];                
                    #borramos el id, ya que el modelo a registrar aun no tiene id
                    if(!isset($this->id) && empty($this->id)){
                        $modeloEncontrado['id']="";
                    }
                    
                    if($this->attributes==$modeloEncontrado){
                        $this->addError("notificacion", "El lugar a registrar ya existe!");
                        $this->addError("lugarEncontrado", $lugar);
                    }
                }
            }
        }
    }
    
    
    
   
}
