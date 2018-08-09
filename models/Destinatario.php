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
            ]
        );
    }
    
    public function existePersonaEnRegistral(){
        $resultado = false;
        
        $response = \Yii::$app->registral->buscarPersonaPorId($this->personaid);
        
        print_r($response);die();
        if(isset($response['estado']) && $response['estado']==true){
            $resultado = true;
        }
        
        return $resultado;
    }


    public function setAttributes($param, $safeOnly = true) {
        
//        if(isset($param['persona']['nro_documento']) && preg_match("/^[0-9]+$/", $param['persona']['nro_documento'])){
//            $resultado = \Yii::$app->registral->buscarPersonaPorNroDocumento($param['persona']['nro_documento']);
//            
//            if(isset($resultado['resultado'][0]['id'])){
//                $personaid= intval($resultado['resultado'][0]['id']);                
//            }
//        }
        
        $personaForm = new PersonaForm();
        $hogarForm = new HogarForm();
        $nucleoForm = new NucleoForm();
        
        if(!isset($param['persona'])){
            $arrayErrors['persona']=$personaForm->getErrors();
            throw new Exception(json_encode($arrayErrors));
        }       
        if(!isset($param['persona']['hogar'])){
            $arrayErrors['hogar']=$hogarForm->getErrors();
            throw new Exception(json_encode($arrayErrors));
        }
        
        $personaForm->setAttributes($param['persona']);
        $hogarForm->setAttributes($param['persona']['hogar']);

        if(!$personaForm->validate()){
            $arrayErrors['persona']=$personaForm->getErrors();
            throw new Exception(json_encode($arrayErrors));
        }                
        
        if(!$hogarForm->validate()){
            $arrayErrors['hogar']=$hogarForm->getErrors();
            throw new Exception(json_encode($arrayErrors));
        } 
        
        $param_persona = $personaForm->toArray();
        $param_persona['hogar'] = $hogarForm->toArray();
        $param_persona['nucleo']['nombre'] = 'Predeterminado';
        
        //se debe hacer un buscado de nucleo
        if(!isset($param['persona']['nucleoid']) && isset($param['persona']['hogar'])){
//            die('entra');
            $response = \Yii::$app->registral->buscarHogar($param['persona']['hogar']);
//            print_r($response);die();
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
        
        //Si es una persona con id entonces ya existe en Registral
        //ejecutamos la interoperabilidad
        if(isset($personaForm->id) && !empty($personaForm->id)){
            //actualizamos la persona
            $param_persona = $personaForm->toArray();
            $param_persona['hogar'] = $hogarForm->toArray();
            $param_persona['nucleo']['id'] = $personaForm->nucleoid;
            \Yii::$app->registral->actualizarPersona($param_persona);
        }else{
            //no tiene id Persona()
            //creamos una persona nueva
            $personaid = intval(\Yii::$app->registral->crearPersona($param_persona));
            $personaForm->id = $personaid;
        }
            
        
        
        //seteamos lo datos de Destinatario
        if(isset($param['destinatario'])){
            parent::setAttributes($param['destinatario'], $safeOnly);
            
            $this->fecha_ingreso = date('Y-m-d');
            $this->personaid = $personaForm->id;
        }
        
        
    }
}
