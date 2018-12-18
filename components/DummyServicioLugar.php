<?php

namespace app\components;
use yii\base\Component;
use GuzzleHttp\Client;
use Exception;


/**
 * Description of ServicioLugar
 *
 * @author cep11p
 */
class DummyServicioLugar extends Component implements IServicioLugar
{
    public $base_uri;
    private $_client;
   
    public function __construct(Client $guzzleClient, $config=[])
    {
        parent::__construct($config);
        $this->_client = $guzzleClient;
    }
   
    /**
     * Buscar la localidad por id y devuelve los datos de la localidad encontrada
     * @param int $id
     * @return boolean
     */
    public function buscarLocalidadPorId($id)
    {
       
        #injectamos el array de datos (mock)
        $data = require(\Yii::getAlias('@app').'/components/DataLocalidad.php');
        
        #preparamos el resultado
        $resultado = array(
            "success"=>FALSE,
            "resultado"=>array()
        );
        
        #filtramos por la clave el array $data
        $modelEncontrado = Help::filter_by_value($data, 'id', $id);        
        
        if($modelEncontrado){
            $resultado['success'] = true;
            $resultado['resultado'] = $modelEncontrado;
        }
        
        return $resultado;
       
    }
    
    public function crearLugar($data)
    {
        return 1;
    }
    
    
    public function buscarLugar($param)
    {
        #injectamos el array de datos (mock)
        $data = require(\Yii::getAlias('@app').'/components/DataLugar.php');   
        
        
        $arrayEncontrado = Help::filtrarArrayAsociativo($data, $param);
        
        $response = $coleccion = array(
            "success"=>true,
            "resultado"=>array(),
        );
        if(isset($arrayEncontrado)){
            $response['resultado'][] = $arrayEncontrado;
        }
        
        return $response;
       
    }
    
    public function buscarLugarIdentico($param)
    {
        #injectamos el array de datos (mock)
        $data = require(\Yii::getAlias('@app').'/components/DataLugar.php');   
        
        
        $arrayEncontrado = Help::filtrarArrayAsociativo($data, $param);
        
        $response = $coleccion = array(
            "success"=>true,
            "resultado"=>array(),
        );
        if(isset($arrayEncontrado)){
            $response['resultado'][] = $arrayEncontrado;
        }
        
        return $response;
       
    }
    
    public function buscarLocalidad($param)
    {
        
        $criterio = $this->crearCriterioBusquedad($param);
        $client =   $this->_client;
        try{
            $headers = [
//                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_LUGAR'],
                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://api.lugar.local/api/localidad?'.$criterio, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::error($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    public function buscarLugarPorId($id)
    {
       
        #injectamos el array de datos (mock)
        $data = require(\Yii::getAlias('@app').'/components/DataLugar.php');
        
        #preparamos el resultado
        $resultado = array(
            "success"=>FALSE,
            "resultado"=>array()
        );
        
        #filtramos por la clave el array $data
        $modelEncontrado = Help::filter_by_value($data, 'id', $id);        
        
        if($modelEncontrado){
            $resultado['success'] = true;
            $resultado['resultado'] = $modelEncontrado;
        }
        
        return $resultado;
    }
    
    
    /**
     * crear un string con los criterio de busquedad por ejemplo: localidadid=1&calle=mata negra&altura=123
     * @param array $param
     * @return string
     */
    public function crearCriterioBusquedad($param){
        //funcion armar url con criterio de busquedad
        $criterio = '';
        $primeraVez = true;
        foreach ($param as $key => $value) {
            if($primeraVez){
                $criterio.=$key.'='.$value;
                $primeraVez = false;
            }else{
                $criterio.='&'.$key.'='.$value;
            }            
        }
        
        return $criterio;
    }
    
    
    
    /**
     * 
     * @param int $nro_documento
     * @return int personaid
     */
    public static function buscarPersonaEnRegistralPorNumeroDocuemento($nro_documento)
    {
        $resultado = null;
        
        return $resultado;
    }
   
   
   
       
}