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
        $arrayErrors = array();
        
        ####### Instanciamos atributos de Destinatario #########
        if(isset($param['destinatario'])){            
            parent::setAttributes($param['destinatario']);
            $this->fecha_ingreso = (empty($this->fecha_ingreso))?date('Y-m-d H:i:s'):$this->fecha_ingreso;
            
            $this->experiencia_laboral = (isset($param['destinatario']['experiencia_laboral']) && ($param['destinatario']['experiencia_laboral']===true))?1:0;
            
        }
        if(!$this->validate()){
            $arrayErrors=ArrayHelper::merge($arrayErrors, array('destinatario'=>$this->getErrors()));
        } 
        
        ####### Instanciamos atributos de PersonaForm #########
        if(isset($param['destinatario']['persona'])){
            $personaForm->setAttributesAndSave($param['destinatario']['persona']);
            $this->personaid = $personaForm->id;
        }   
        
       
        ###### chequeamos si existen errores ###############        
        if(count($arrayErrors)>0){
            throw new Exception(json_encode($arrayErrors));
        }       
        
    }
    
   
    /** para obtener este dato se requiere hacer una interoperabilidad con el sistema Registral**/
    public function getPersona(){
        $resultado = null;
        $model = new PersonaForm();
        $arrayPersona = $model->buscarPersonaPorIdEnRegistral($this->personaid);

        if($arrayPersona){
            $resultado = $arrayPersona;
        }        
        
        return $resultado;        
    }

    public function fields()
    {        
        $resultado = ArrayHelper::merge(parent::fields(), [
//            'profesion'=> function($model){
//                return $model->profesion->nombre;
//            },
//            'oficio'=> function($model){
//                return $model->oficio->nombre;
//            },
//            'persona'=> function($model){
//                return $model->persona;
//            }
        ]);
        
        return $resultado;
    
    }
    
}
