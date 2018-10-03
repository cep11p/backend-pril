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
            [['email'], 'string', 'max' => 200],            
            [['email'], 'email'],
            [['fecha_nacimiento'], 'date', 'format' => 'php:Y-m-d'],
            ['nro_documento', 'match', 'pattern' => "/^[0-9]+$/"],
            ['id', 'existeEnRegistral'],
            ['nucleoid', 'existeNucleoEnRegistral','skipOnEmpty' => true],
            ['nro_documento', 'existeNroDocumentoEnRegistral'],
        ];
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
    public function buscarPersonaPorIdEnRegistral(){
        $response = \Yii::$app->registral->buscarPersonaPorId($this->id); 
        
        if(isset($response['estado']) && $response['estado']==true){
            $this->setAttributes(array_shift($response['resultado']));
            
        }
    }
    
    /**
     * Se serializa los datos Persona,Estudios y Lugar para ser mostrados
     * @return array devuelven datos para ser mostrados, caso contrario, se devuelve un array vacio
     */
    public function mostrarPersonaConLugarYEstudios(){
        $response = \Yii::$app->registral->buscarPersonaPorId($this->id); 
        
        $personaArray = array();
        if(isset($response['estado']) && $response['estado']==true){
            $personaArray = $response['resultado'][0];
            
            if(isset($personaArray['hogar'])){
                $lugarid = $personaArray['hogar']['lugarid'];
                $lugarArray = $this->getLugar($lugarid);
                
                unset($personaArray['hogar']);
                $personaArray['lugar'] = $lugarArray;
            }
        }
        
        return $personaArray;
    }
    
    /**
     * Esta funcion busca un lugar en el sistema lugar
     * @param int $id
     * @return array con atributos de lugar, en caso que no exista se devuelve un Null;
     */
    protected function getLugar($lugarid){
        $response = \Yii::$app->lugar->buscarLugarPorId($lugarid);
        $resultado = null;
        if(isset($response['success']) && $response['success']==true){
            $resultado = $response['resultado'][0];
        }
        
        return $resultado;
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
//    public function existeEnRegistral(){
//        $resultado = false;
//        
//        $response = \Yii::$app->registral->buscarPersonaPorId($this->id);       
//        
//        if(isset($response['estado']) && $response['estado']==true){
//            $resultado = true;
//        }
//        
//        return $resultado;
//    }
    
    /**
     * 
     * @param array $param
     * @throws Exception
     */
//    public function agregarHogar($param) {
//        /*** Nucleo y su Hogar ***/ //el param['nucleo']['hogar'] viene con nucleos[] (vacio)
//        if(isset($param['hogar']) && count($param['hogar'])>1){
//            //Instanceamos el hogar a modificar
//            if(isset($param['hogar']['id']) && !empty($param['hogar']['id'])){
//                $hogar = Hogar::findOne(['id'=>$param['hogar']['id']]);
//                $hogar->setAttributes($param['hogar']);
//                
//            }else{
//            //Creamos el hogar nuevo
//                $hogar = new Hogar();
//                $hogar->setAttributes($param['hogar']);
//            }
//            
//            if(!$hogar->save()){
//                $arrayErrors['hogar']=$hogar->getErrors();
//                $arrayErrors['tab']='hogar';
//                $resultado['success']=false;
//                throw new Exception(json_encode($arrayErrors));
//            }
//            
//            /*** Nucleo ***/
//            /******************************/
//            
//            //Si ya existe el nucleo
//            if(isset($param['nucleo']['id']) && !empty($param['nucleo']['id'])){
//                //si id no es un entero
//                if(!is_int($param['nucleo']['id'])){
//                    $msj = 'El id nucleo es incorrecto';
//                    throw new Exception($msj);
//                }
//                
//                $nucleo = Nucleo::findOne(['id'=>$param['nucleo']['id']]);
//                
//                if($nucleo==null){
//                    $msj = 'El nucleo no existe!!';
//                    throw new Exception($msj);
//                }
//                
//                if(!in_array($nucleo, $hogar->nucleos)){
//                    $msj = 'El nucleo no pertenece al hogar';
//                    throw new Exception($msj);
//                }
//                
//            }else{
//                $nucleo = new Nucleo();
//                $nucleo->hogarid = $hogar->id;
//
//                if(isset($param['nucleo']['nombre']) && !empty($param['nucleo']['nombre'])){
//                    $nucleo->nombre = $param['nucleo']['nombre'];
//                }else{
//                    $this->addError('nombre', 'Se debe crear o seleccionar un Nucleo');
//                }
//                
//                if(!$nucleo->save()){
//                    $arrayErrors['nucleo']=$nucleo->getErrors();
//                    $arrayErrors['tab']='nucleo';
//                    $resultado['success']=false;
//                    throw new Exception(json_encode($arrayErrors));
//                }
//
//            }
//
//            //instanciamos el nucleo a la persona actual
//            $this->nucleoid = $nucleo->id;
//            
//        }
//    }
    
    /**
     * Buscamos si existe la persona con el nro_documento
     * @return bool
     */
    public function existePersonaConNroDocumento()
    {
        
        $per = Persona::findOne(["nro_documento"=>$this->nro_documento]);
        $resultado = true;
        
        if($per==NUll){
            $resultado = false;
        }
        
        return $resultado;
    }
    
    public function getHogar()
    {
        $nucleo = Nucleo::findOne([['id'=>$this->nucleoid]]);
        $arrayHogar = array();
        if($nucleo!=NULL){
            
            $hogar = Hogar::findOne(['id'=>  $nucleo->hogarid]);
            
            if($hogar!=NULL){
                $arrayHogar = $hogar;
            }
            
        }
        
        return $arrayHogar;
    }
    
    
    
    
   
}
