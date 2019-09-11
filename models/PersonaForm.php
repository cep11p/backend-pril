<?php

namespace app\models;


use yii\helpers\ArrayHelper;
use Yii;
use yii\base\Model;

use yii\base\Exception;
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
                        
            [['nombre', 'apellido','nro_documento','fecha_nacimiento','estado_civilid','sexoid','generoid','email'], 'required'],
            [['estado_civilid', 'sexoid', 'tipo_documentoid', 'nucleoid', 'situacion_laboralid', 'generoid','id'], 'integer'],
            [['nombre', 'apellido', 'nro_documento', 'telefono', 'celular'], 'string', 'max' => 45],
            [['cuil'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 200],            
            [['email'], 'email'],
            [['fecha_nacimiento'], 'date', 'format' => 'php:Y-m-d'],
            ['nro_documento', 'match', 'pattern' => "/^[0-9]+$/"]
        ];
    }
    
    
    public function save(){
        
        if($this->validate()){
            $resultado = null;
            if(isset($this->id) && !empty($this->id)){
                $personaid = intval(\Yii::$app->registral->actualizarPersona($this->toArray()));
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
    
    public function setAttributesAndSave($param = array()) {
        
        
        ####### Instanciamos atributos de PersonaForm #########
        $this->setAttributes($param);
        if(!$this->validate()){
            $arrayErrors = ArrayHelper::merge($arrayErrors, $this->getErrors());
        }   
        
        ####### Instanciamos atributos de LugarForm #########
        $lugarForm = new LugarForm();
        if(isset($param['lugar'])){
            $lugarForm->setAttributes($param['lugar']);
        }                
        
        if(!$lugarForm->validate()){
            $arrayErrors=ArrayHelper::merge($arrayErrors, $lugarForm->getErrors());
        } 
        
        ###### chequeamos si existen errores ###############        
        if(count($arrayErrors)>0){
            throw new Exception(json_encode($arrayErrors));
        }
        
        #Preparamos los parametros para interoperar con registral
        $param_persona = $this->toArray();
        $param_persona['estudios'] = (isset($param['estudios']))?$param['estudios']:array();
        $param_persona['lista_red_social'] = (isset($param['lista_red_social']))?$param['lista_red_social']:array();
        $param_persona['lugar'] = $lugarForm->toArray();
        
        /*************** Ejecutamos la interoperabilidad ************************/
        //Si es una persona con id entonces ya existe en Registral
        if(isset($this->id) && !empty($this->id)){
            $resultado = \Yii::$app->registral->actualizarPersona($param_persona);
            if(isset($resultado->message)){
                throw new Exception($resultado->message);
            }
            $this->id = intval($resultado);
            
        }else{
            $resultado = \Yii::$app->registral->crearPersona($param_persona);
            if(isset($resultado->message)){
                throw new Exception($resultado->message);
            }
            $this->id = intval($resultado);
        }
        
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
     * Del sistema registral obtenemos un array con datos, y de lo obtenido manipulamos los atributos relevantes para instanciar un persona PersonaForm, 
     * El array obtenido es como el siguiente ejemplo
     * 
        {
            "estado": true,
            "resultado": [
                {
                    "id": 1,
                    "nombre": "Alejandra",
                    "apellido": "Rodríguez",
                    "apodo": "rominochi",
                    "nro_documento": "29890010",
                    "fecha_nacimiento": "1980-12-12",
                    "estado_civilid": 1,
                    "telefono": "2920430690",
                    "celular": "2920412127",
                    "sexoid": 2,
                    "tipo_documentoid": 1,
                    "nucleoid": 1,
                    "situacion_laboralid": 1,
                    "generoid": 1,
                    "email": "algo@correo.com.ar",
                    "cuil": "20367655678",
                    "hogar": {
                        "id": 1,
                        "tiene_gas": 0,
                        "tiene_luz": 0,
                        "tiene_agua": 0,
                        "condicion_ocupacionid": 1,
                        "obtencion_aguaid": 1,
                        "tipo_desagueid": 1,
                        "cocina_combustibleid": 1,
                        "tipo_viviendaid": 1,
                        "jefeid": null,
                        "habitacion_dormir": 2,
                        "banioid": 1,
                        "lugarid": 1,
                        "observacion": null,
                        "nucleos": [
                            {
                                "id": 1,
                                "hogarid": 1,
                                "jefeid": null,
                                "nombre": "Familia Rodriguez"
                            }
                        ]
                    },
                    "estudios": [
                        {
                            "id": 7,
                            "titulo": "tecnico en desarrollo web",
                            "completo": 1,
                            "en_curso": 0,
                            "nivel_educativoid": 4,
                            "nivel_educativo": "Terciario",
                            "anio": "2014"
                        },
                        {
                            "id": 8,
                            "titulo": "nutricionista",
                            "completo": 1,
                            "en_curso": 0,
                            "nivel_educativoid": 4,
                            "nivel_educativo": "Terciario",
                            "anio": "2014"
                        }
                    ],
                    "sexo": "Mujer",
                    "genero": "Masculino",
                    "estado_civil": "Soltero/a",
                    "lugar": {
                        "id": 1,
                        "nombre": null,
                        "calle": "Mitre",
                        "altura": "123",
                        "localidadid": 1,
                        "latitud": null,
                        "longitud": null,
                        "barrio": "Inalauquen",
                        "piso": "",
                        "depto": "",
                        "escalera": "",
                        "localidad": "Capital Federal"
                    }
                }
            ]
        }
     * 
     */
    public function buscarPersonaPorIdEnRegistral($id){
        $response = \Yii::$app->registral->buscarPersonaPorId($id); 
        
        if(isset($response['id'])){
            unset($response['hogar']);
        }
        
        return $response;
    }
    
    public function buscarPersonaEnRegistral($param){
        $resultado = array();
        $response = \Yii::$app->registral->buscarPersona($param); 
        
        if(isset($response['estado']) && $response['estado']==true){
            
            foreach ($response['resultado'] as $persona) {                
                unset($persona['hogar']);
                
                $resultado[] = $persona;
            }
        }
        
        return $resultado;
    }
    
    /**
     * Cuando obtenemos una Persona por interoperabilidad, en el resultado viene un array llamado lugar, 
     * donde este hace referencia a los datos de direccion o georeferencias
     * @param int $id este atributo hace referencia a una persona
     * @return array Devolvemos el lugar que asociado la persona intanciada
     */
    public function getLugar($id){
        $resultado = null;
        $response = \Yii::$app->registral->buscarPersonaPorId($id);
        
        if(isset($response['estado']) && $response['estado']==true){
            $personaArray = $response['resultado'][0];
            
            if(isset($personaArray['lugar'])){
                $resultado = $personaArray['lugar'];
            }
            
        }
        
        return $resultado;
    }
    
    /**
     * Se serializa los datos Persona,Estudios y Lugar para ser mostrados.
     * NOTA! Tener encuenta que Estudio y Lugar no son partes de PersonaForm
     * @return array devuelven datos para ser mostrados, caso contrario, se devuelve un array vacio
     */
    public function obtenerPersonaConLugarYEstudios($id = null){
        
        if($id){
            $response = \Yii::$app->registral->buscarPersonaPorId($id); 
        }else{
            $response = \Yii::$app->registral->buscarPersonaPorId($this->id);
        }
         
        
        $personaArray = array();
        if(isset($response['estado']) && $response['estado']==true){
            $personaArray = $response['resultado'][0];
            
            #Sacamos el parametro lugar que para pril es irrelevante
            unset($personaArray['apodo']);
            unset($personaArray['hogar']);
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
     * vamos a cheaquear si existen cambios en los atributos
     */
    public function existeModificacion($params){
        $existeModificacion = false;
        foreach ($this->attributes as $key => $value) {
            if($params[$key] != $value){
                $existeModificacion = true;
            }
        }
        return $existeModificacion;
    }
    
     
    
    
    
   
}
