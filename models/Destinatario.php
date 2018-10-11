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
                [['fecha_ingreso'], 'date', 'format' => 'php:Y-m-d H:i:s'],
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
     * Se instancian los atributos de Destinatario, Persona, Hogar y una coleccion de estudios.
     * @param array $param parametros son de Destinatario, Persona, Hogar y una coleccion de Estudios
     * @throws Exception
     */
    public function setAttributesAndValidate($param) {
        
        $personaForm = new PersonaForm();
        $nucleoForm = new NucleoForm();
        $nucleoForm->nombre = "Predeterminado";
        $hogarForm = new HogarForm();
        $lugarForm = new LugarForm();
        $arrayErrors = array();
        
  
        
        ####### Instanciamos atributos de Destinatario #########
        if(isset($param['destinatario'])){            
            parent::setAttributes($param['destinatario']);
            $this->fecha_ingreso = date('Y-m-d H:i:s');
            
            $this->experiencia_laboral = (isset($param['destinatario']['experiencia_laboral']) && ($param['destinatario']['experiencia_laboral']===true))?1:0;
            
        }
        if(!$this->validate()){
            $arrayErrors=ArrayHelper::merge($arrayErrors, array('destinatario'=>$this->getErrors()));
        } 
        
        ####### Instanciamos atributos de PersonaForm #########
        if(isset($param['persona'])){
            $personaForm->setAttributes($param['persona']);
        }           
        if(!$personaForm->validate()){
            $arrayErrors = ArrayHelper::merge($arrayErrors, array('persona' => $personaForm->getErrors()));
        }   
        
        ####### Instanciamos atributos de LugarForm #########
        if(isset($param['persona']['lugar'])){
            $lugarForm->setAttributes($param['persona']['lugar']);
        }                
        
        if(!$lugarForm->validate()){
            $arrayErrors=ArrayHelper::merge($arrayErrors, array('lugar'=>$lugarForm->getErrors()));
        } 
        
       
        ###### chequeamos si existen errores ###############        
        if(count($arrayErrors)>0){
            throw new Exception(json_encode($arrayErrors));
        }

        /********************** Instanciamos un coleccion de Estudios *********************/
        if(isset($param['persona']['estudios'])){
            $coleccionEstudio = array();
            foreach ($param['persona']['estudios'] as $estudio) {
                $coleccionEstudio[] = $this->serializarEstudio($estudio);
            } 
            $param_persona['estudios'] = $coleccionEstudio;           
        }
        
        /*************** Lugar/Hogar/Nucleo ******************/
        //se debe hacer un buscado de nucleo mediante los datos de direccion que tiene lugar[]
        if($lugarForm->validate()){
            $lugarEncontrado = $lugarForm->buscarLugarEnSistemaLugar();
            //Verificamos si existe el lugar y seteamos el hogar con el nucleo que corresponde
            if($lugarEncontrado!=null){
                $hogarForm->lugarid = $lugarEncontrado['id'];
                $hogarEncontrado = $hogarForm->buscarHogarEnSistemaRegistral();
                
                if($hogarEncontrado!=null){
                    $hogarForm->setAttributes($hogarEncontrado);
                    $nucleoEncontrado = $nucleoForm->buscarNucleoEnSistemaRegistral(['hogarid'=>$hogarForm->id,'nombre'=>'Predeterminado']);
                }
                
                if(isset($nucleoEncontrado)){
                    $nucleoForm->setAttributes($nucleoEncontrado);
                    $nucleoForm->validate();
                    //instanceamos el nucleo encontrado
                    $personaForm->nucleoid = $nucleoForm->id;  
                }             
            }
        }
        
        $param_persona = $personaForm->toArray();
        $param_persona['estudios'] = $coleccionEstudio;
        $param_persona['hogar'] = $hogarForm->toArray();
        $param_persona['lugar'] = $lugarForm->toArray();
        $param_persona['nucleo'] = $nucleoForm->toArray();
        
        /*************** Ejecutamos la interoperabilidad ************************/
        //Si es una persona con id entonces ya existe en Registral
        $personaid = 0;
        if(isset($personaForm->id) && !empty($personaForm->id)){
            $personaid = intval(\Yii::$app->registral->actualizarPersona($param_persona));
            $personaForm->id = $personaid;
            
        }else{
            $personaid = intval(\Yii::$app->registral->crearPersona($param_persona));
            $personaForm->id = $personaid;
        }
        
        /*****************seteamos a la persona instanciada de Destinatario********************/
        $this->personaid = $personaid;
        
        
        
    }
    
    public function agregarColeccionEstudio($param){
        
        foreach ($param as $est){
            $estudio = new EstudioForm();
            $estudio->setAttributes($est);
        }
        
        return $resultado;
    }
    
    /**
     * Se instancia un estudio y se valida y luego se serializa como parametro con el fin de ser registrado con interoperabilidad
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
        
    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'profesion'=> function($model){
                return $model->profesion->nombre;
            },
            'oficio'=> function($model){
                return $model->oficio->nombre;
            },
        ]);
    
    }
    
}
