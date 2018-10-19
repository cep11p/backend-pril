<?php

namespace app\models;


use yii\helpers\ArrayHelper;
use Yii;
use yii\base\Model;

/**
 * This is the model class for table "persona".
 */
class PersonaForm extends Model
{
    public $id;
    public $nombre;
    public $apellido;
    public $nro_documento;
    public $fecha_nacimiento;
    public $estado_civilid;
    public $telefono;
    public $celular;
    public $sexoid;
    public $tipo_documentoid;
    public $nucleoid;
    public $situacion_laboralid;
    public $generoid;
    public $email;
    public $cuil;

    public function rules()
    {
        return [
                        
            [['nombre', 'apellido','nro_documento','fecha_nacimiento','estado_civilid','email','sexoid','generoid'], 'required'],
            [['estado_civilid', 'sexoid', 'tipo_documentoid', 'nucleoid', 'situacion_laboralid', 'generoid','id'], 'integer'],
            [['nombre', 'apellido', 'nro_documento', 'telefono', 'celular'], 'string', 'max' => 45],
            [['cuil'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 200],            
            [['email'], 'email'],
            [['fecha_nacimiento'], 'date', 'format' => 'php:Y-m-d'],
            ['nro_documento', 'match', 'pattern' => "/^[0-9]+$/"],
            ['id', 'existeEnRegistral'],
            ['nucleoid', 'existeNucleoEnRegistral','skipOnEmpty' => true],
            ['nro_documento', 'existeNroDocumentoEnRegistral'],
        ];
    }
    
    
    public function save(){
        
        if($this->validate()){
            $resultado = null;
            if(isset($this->id) && !empty($this->id)){
                $personaid = intval(\Yii::$app->registral->actualizarPersona($this->attributes()));
                $this->id = $personaid;
                $resultado = $this->id;
            }else{
                $personaid = intval(\Yii::$app->registral->crearPersona($this->toArray()));
                $this->id = $personaid;
                $resultado = $this->id;
            }
        }else{
            $resultado = false;
        } 
            
        
        
        return $resultado;
    }
    
    /**
     * Ademas de registrar los datos personales, se registran los datos del hogar
     * @param array $param
     * @param bool $safeOnly
     * @throws Exception
     */
    public function setAttributes($param) {
        /*** Persona ***/
        parent::setAttributes($param);
        
        /*Fecha Nacimiento*/
        if(isset($param['fecha_nacimiento']) && !empty($param['fecha_nacimiento'])){
            $this->fecha_nacimiento = Yii::$app->formatter->asDate($param['fecha_nacimiento'], 'php:Y-m-d');
        }  
        
    }
    
    /**
     * Se cargar los atributos de la persona encontrada
     * @param int $id
     */
    public function buscarPersonaPorIdEnRegistral($id){
        $response = \Yii::$app->registral->buscarPersonaPorId($id); 
        
        if(isset($response['estado']) && $response['estado']==true){
            $this->setAttributes(array_shift($response['resultado']));
            
        }
    }
    
    /**
     * Se serializa los datos Persona,Estudios y Lugar para ser mostrados.
     * NOTA! Tener encuenta que Estudio y Lugar no son partes de PersonaForm
     * @return array devuelven datos para ser mostrados, caso contrario, se devuelve un array vacio
     */
    public function mostrarPersonaConLugarYEstudios(){
        $response = \Yii::$app->registral->buscarPersonaPorId($this->id); 
        
        $personaArray = array();
        if(isset($response['estado']) && $response['estado']==true){
            $personaArray = $response['resultado'][0];
            
            #Sacamos el parametro lugar que para pril es irrelevante
            if(isset($personaArray['hogar'])){
                unset($personaArray['hogar']);
            }
        }
        
        return $personaArray;
    }

    /**
     * 
     * @param array $param
     */
    public function agregarEstudios($param) {
        /**Seteamos uno o mas Estudios**/
        //limpiamos la coleccion vieja de estudios
        Estudio::deleteAll(['personaid'=>$this->id]);         
        foreach ($param as $est){

            $estudio = new Estudio();
            $estudio->setAttributes($est);
            $estudio->personaid = $this->id;
            if(!$estudio->save()){
                $arrayErrors['estudios']=$estudio->getErrors();
                $arrayErrors['tab']='estudios';
                $resultado['success']=false;
                throw new Exception(json_encode($arrayErrors));
            }
        }
    }
    
    /**
     * Una validacion Rule()
     */
    public function existeEnRegistral(){
        $response = \Yii::$app->registral->buscarPersonaPorId($this->id);       
        
        if(isset($response['estado']) && $response['estado']!=true){
            $this->addError('id', 'La persona con el id '.$this->id.' no existe!');
        }
    }
    public function existeNucleoEnRegistral(){
        $response = \Yii::$app->registral->buscarNucleo($this->nucleoid);       
        
        if(isset($response['estado']) && $response['estado']!=true){
            $this->addError('nucleoid', 'El nucleo con el id '.$this->nucleoid.' no existe!');
        }
    }
    public function existeNroDocumentoEnRegistral(){
        
        if(!isset($this->id)){
            $response = \Yii::$app->registral->buscarPersonaPorNroDocumento($this->nro_documento);       

            if(isset($response['estado']) && $response['estado']==true){
                $this->addError('nro_documento', 'El nro de documento '.$this->nro_documento.' ya está en uso!');
            }
        }
    }
    
     
    
    
    
   
}
