<?php

namespace app\models;

use Yii;
use \app\models\base\Destinatario as BaseDestinatario;
use yii\helpers\ArrayHelper;
use app\components\ServicioPersona;
use GuzzleHttp\Client;
use yii\base\Exception;
/**
 * This is the model class for table "destinatario".
 */
class Destinatario extends BaseDestinatario
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
                [['fecha_presentacion'], 'date', 'format' => 'php:Y-m-d'],
                [['fecha_ingreso'], 'date', 'format' => 'php:Y-m-d'],
                [['fecha_ingreso'], 'date', 'format' => 'php:Y-m-d'],
                ['personaid', 'compare','compareValue'=>0,'operator'=>'!=','message' => 'No se pudo registrar la persona correctamente en el Sistema Registral.'],
            ]
        );
    }
    
//    public function existePersonaEnRegistral(){
//        $response = \Yii::$app->registral->buscarPersonaPorId($this->personaid);
//        
//        if(isset($response['estado']) && $response['estado']!=true){
//            $this->addError('personaid', 'El nivel educativo con el id '.$this->nivel_educativoid.' no existe!');
//        }
//
//    }

    /**
     * 
     * @param array $param estos parametros son de Destinatario, Persona, Hogar y una coleccion de Estudios
     * @throws Exception
     */
    public function setAttributesAndValidate($param) {
        
        $personaForm = new PersonaForm();
        $hogarForm = new HogarForm();
        $arrayErrors = array();
        
  
        if(isset($param['destinatario'])){            
            parent::setAttributes($param['destinatario']);
        }
        
        if(isset($param['persona'])){
            $personaForm->setAttributes($param['persona']);
        }       
        if(isset($param['persona']['hogar'])){
            $hogarForm->setAttributes($param['persona']['hogar']);
        }

        if(!$personaForm->validate()){
            $arrayErrors = ArrayHelper::merge($arrayErrors, array('persona' => $personaForm->getErrors()));
        }                
        
        if(!$hogarForm->validate()){
            $arrayErrors=ArrayHelper::merge($arrayErrors, array('hogar'=>$hogarForm->getErrors()));
        } 
        
        if(!$this->validate()){
            $arrayErrors=ArrayHelper::merge($arrayErrors, array('destinatario'=>$this->getErrors()));
        } 
        
        if(count($arrayErrors)>0){
            throw new Exception(json_encode($arrayErrors));
        }

        
        if(isset($param['persona']['estudios'])){
            $coleccionEstudio = array();
            foreach ($param['persona']['estudios'] as $estudio) {
//                $coleccionEstudio = ArrayHelper::merge($coleccionEstudio, $this->agregarEstudio($estudio));
                $coleccionEstudio[] = $this->serializarEstudio($estudio);
            } 
            $param_persona['estudios'] = $coleccionEstudio;           
        }
        
        //se debe hacer un buscado de nucleo mediante los datos de direccion que tiene hogar[]
        if(!isset($param['persona']['nucleoid']) && isset($param['persona']['hogar'])){
//            die('entra');
            $response = \Yii::$app->registral->buscarHogar($param['persona']['hogar']);
            
            //Verificamos si existe el hogar
            if(isset($response['estado']) && $response['estado']==true && isset($response['resultado'][0]['id'])){
                //existe hogar
                $hogarForm->id = $response['resultado'][0]['id'];
                $nucleoPredeterminado = \Yii::$app->registral->buscarNucleo($hogarForm->id);
                if(isset($nucleoPredeterminado['estado']) && $nucleoPredeterminado['estado']==true && isset($nucleoPredeterminado['resultado'][0]['id'])){
                    //instanceamos el nucleo encontrado
                    $personaForm->nucleoid = $nucleoPredeterminado['resultado'][0]['id'];  
                }              
            }
        }
        
        $param_persona = $personaForm->toArray();
        $param_persona['estudios'] = $coleccionEstudio;
        $param_persona['hogar'] = $hogarForm->toArray();
        $param_persona['nucleo']['nombre'] = 'Predeterminado';
        $param_persona['nucleo']['id'] = (isset($personaForm->nucleoid))?$personaForm->nucleoid:null;
        
        /*************** Ejecutamos la interoperabilidad ************************/
        //Si es una persona con id entonces ya existe en Registral
        if(isset($personaForm->id) && !empty($personaForm->id)){
            $personaid = intval(\Yii::$app->registral->actualizarPersona($param_persona));
            $personaForm->id = $personaid;
            
        }else{
            $personaid = intval(\Yii::$app->registral->crearPersona($param_persona));
            $personaForm->id = $personaid;
        }
        
        //seteamos lo datos de Destinatario
        
        $this->fecha_ingreso = date('Y-m-d');
        $this->personaid = $personaForm->id;
        
        
        
    }
    
    public function agregarColeccionEstudio($param){
        
        foreach ($param as $est){
            $estudio = new EstudioForm();
            $estudio->setAttributes($est);
        }
        
        return $resultado;
    }
    
    /**
     * Se valida el estudio y luego se serializa
     * @param array $param
     * @return array
     * @throws Exception si el estuio no es valido, creamos una excepcion con los errores
     */
    public function serializarEstudio($param){
        
        $estudioForm = new EstudioForm();
        $estudioForm->setAttributes($param);
        
        if(!$estudioForm->validate()){
            $arrayErrors['estudios']=$estudioForm->getErrors();
            throw new Exception(json_encode($arrayErrors));
        }
        
        return $estudioForm->toArray();
    }
}
