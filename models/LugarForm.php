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
    public $usarLugarEncontrado;

    public function rules()
    {
        return [
            [['calle', 'altura', 'localidadid'], 'required'],
            [['localidadid','id'], 'integer'],
            [['usarLugarEncontrado'], 'boolean'],
            [['nombre', 'calle', 'altura', 'latitud', 'longitud', 'barrio', 'piso', 'depto', 'escalera'], 'string', 'max' => 200],
            ['localidadid','existeLocalidadEnSistemaLugar'],
            ['localidadid','existeLugarIdentico'],//aprovechamos que localidadid es obligatorio, para realizar siempre una busquedad de lugar
        ];
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
     * Vamos a ver si existe un lugar identico en el sistema lugar, es decir
     * que vamos a chequear si coinciden los atributos
     * @return LugarForm $lugarEncontrado;
     */
    public function buscarLugarEnSistemaLugar() {
        
        $resultado = null;
        $response = \Yii::$app->lugar->buscarLugar($this->attributes);   
        
        if(isset($response['success']) && $response['success']==true){

            if(count($response['resultado'])>0){            
                foreach ($response['resultado'] as $modeloEncontrado){
                    $lugarEncontrado = $modeloEncontrado;                
                    $lugarARegistrar = $this->attributes;
                    
                    #borramos el siguiente atributo por el modelo de lugarEncontrado no lo tiene
                    unset($lugarARegistrar['usarLugarEncontrado']);
                    
                    #borramos el id, ya que el modelo a registrar aun no tiene id
                    if(!isset($this->id) && empty($this->id)){
                        $modeloEncontrado['id']="";
                    }
                    
                    if($lugarARegistrar==$modeloEncontrado){
                        $resultado = $lugarEncontrado;
                        
                    }
                }
            }
        }
        
        return $resultado;
    }
    
    /**
     * Vamos a verificar si existe comparando todos los atributos, 
     * si existe, se notificará y se enviara el id del lugar con el fin de ser utilizado si se quiere
     */
    public function existeLugarIdentico(){

        if(!isset($this->usarLugarEncontrado) || $this->usarLugarEncontrado==false){
            if($this->buscarLugarEnSistemaLugar()!=null){
                $lugarEncontrado = $this->buscarLugarEnSistemaLugar();
                $this->addError("notificacion", "El lugar a registrar ya existe!");
                $this->addError("lugarEncontrado", $lugarEncontrado);
            }
        }
        
    }
    
    /**
     * Es regla regla solo se usa en el actionCreate
     * Vamos a verificar si existe $this->id en el sistemaLugar
     */
    public function existeLugarEnSistemaLugar(){
        $response = \Yii::$app->lugar->buscarLugarPorId($this->id);   
            if(isset($response['success']) && $response['success']==true){
                return true;
            }else{
                return false;
            }
    }
    
    
    
    
}
