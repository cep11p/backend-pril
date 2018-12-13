<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "Lugar".
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
        ];
    }
    
    /**
     * Se registra un lugar con el sistemaLugar (interoperabilidad)
     * @return boolean
     */
    public function save(){
        $resultado = null;
        
        if($this->validate()){
            $id = intval(\Yii::$app->lugar->crearLugar($this->toArray()));
            $resultado = $this->id = $id;
            
        }else{
            $resultado = false;
        } 
        
        return $resultado;
    }
    
    /**
     * Vamos a ver si localidadid tiene integridad con el sistema Lugar, 
     * Es decir que el sistema lugar debe tener una tabla Localidad
     */
    public function existeLocalidadEnSistemaLugar() {
        $response = \Yii::$app->lugar->buscarLocalidadPorId($this->localidadid);    
        
        if(isset($response['success']) && $response['success']!=true){
            $this->addError('id', 'La localidad con el id '.$this->id.' no existe!');
        }
    }
    
    /**
     * Vamos a filtrar lugares según el criterio, es decir
     * que vamos a chequear si coinciden los atributos
     * @return LugarForm $lugarEncontrado;
     */
    public function buscarLugarEnSistemaLugar($params = null) {
        
        $resultado = null;
        if(isset($params)){
            $response = \Yii::$app->lugar->buscarLugar($params);   
        }else{
            $response = \Yii::$app->lugar->buscarLugar($this->attributes);
        }
        
        if(isset($response['success']) && $response['success']==true){

            $resultado = $response['resultado'];
        }
        
        return $resultado;
    }
    
    /**
     * Vamos a ver si existe un lugar identico en el sistema lugar, es decir
     * que vamos a buscar un lugar unico
     * @return LugarForm $lugarEncontrado;
     */
    public function buscarLugarIdenticoEnSistemaLugar($params = null) {
        
        $response = array();
        if(isset($params)){
            $response = \Yii::$app->lugar->buscarLugarIdentico($params);   
        }else{
            $response = \Yii::$app->lugar->buscarLugarIdentico($this->attributes);
        }
        
        return $response;
    }
    
    public function buscarLugarPorIdEnSistemaLugar($id) {
        
        $resultado = null;
        $response = \Yii::$app->lugar->buscarLugarPorId($id);   
        
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
