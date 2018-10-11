<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use Yii;
use yii\base\Exception;
/**Models**/
use app\models\Destinatario;
use app\models\PersonaForm;

class DestinatarioController extends ActiveController{
    
    public $modelClass = 'app\models\Destinatario';
    
    public function behaviors()
    {

        $behaviors = parent::behaviors();     

        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className()
        ];

        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        $behaviors['authenticator'] = $auth;

        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
        ];

        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];     

        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::className(),
            'only' => ['*'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ]
        ];



        return $behaviors;
    }
    
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['view']);
//        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    
    }
    
//    public function prepareDataProvider() 
//    {
//        $searchModel = new \app\models\DestinatarioSearch();
////        return $searchModel->busquedadGeneral(\Yii::$app->request->queryParams);
//        $resultado = $searchModel->busquedadGeneral(\Yii::$app->request->queryParams);
//        
//        $data = array('success'=>false);
//        if($resultado->getTotalCount()){
//            $data['success']='true';            
//            $data['resultado']=$resultado->models;
//        }
//
//        return $data;
//    }   
    
    /**
     * Se recibe una id y se buscar el destinatario para ser mostrado
     * @param int $id
     * @return array con los datos de un agente
     */
    public function actionView($id)
    {
        $param = Yii::$app->request->get();
        
//        print_r($param);die();
        $model = new Destinatario();
        $model = $model->findOne(['id'=>$id]);
        
        $resultado = array();
        if(isset($param['modificar']) && $param['modificar']=="true"){
            $resultado = $this->crearVistaModeloModificar($model);
        }else{
            $resultado = $this->crearVistaModelo($model);
        }
        
        
        return $resultado;

    }
    
    /**
     * Se crea un Destinatario y se vincula con una Persona()
     * @return array Un array con datos
     * @throws \yii\web\HttpException
     */
    public function actionCreate()
    {
        $resultado['message']='Se guarda un Destinatario';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            
            $model = new Destinatario();
            $model->setAttributesAndValidate($param);
            //Registrar y validar personaid
            
            if(!$model->save()){
                $arrayErrors['destinatario']=$model->getErrors();
                $arrayErrors['tab']='destinatario';                
                throw new Exception(json_encode($arrayErrors));
            }
            
            $transaction->commit();
            
            $resultado['success']=true;
            $resultado['data']['id']=$model->id;
            
            return  $resultado;
           
        }catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            $transaction->rollBack();
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(500, $mensaje);
        }

    }
    
    /**
     * Se modificar un Destinatario y se vincula con una Persona()
     * @return array Un array con datos
     * @throws \yii\web\HttpException
     */
    public function actionUpdate($id)
    {
        $resultado['message']='Se modifica un Destinatario';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            
            $model = Destinatario::findOne(['id'=>$id]);            
            if($model==NULL){
                $msj = 'El destinatario con el id '.$id.' no existe!';
                throw new Exception($msj);
            }
            
            $model->setAttributesAndValidate($param);
            //Registrar y validar personaid
            
            if(!$model->save()){
                $arrayErrors['destinatario']=$model->getErrors();
                $arrayErrors['tab']='destinatario';                
                throw new Exception(json_encode($arrayErrors));
            }
            
            $transaction->commit();
            
            $resultado['success']=true;
            $resultado['data']['id']=$model->id;
            
            return  $resultado;
           
        }catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            $transaction->rollBack();
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(500, $mensaje);
        }

    }
    
    /**
     * Se recibe el modelo Destinatario para crear un array con sus registros
     * @param Destinatario $model
     * @return array $resultado
     */
    private function crearVistaModelo($model){
        
        
        try{
            $resultado = array();
            
            if($model!=null){
                
                #####Instanceamos la persona a mostrar
                $personaForm = new PersonaForm();
                $personaForm->buscarPersonaPorIdEnRegistral($model->personaid);
                
                if(!isset($personaForm->id)){
                    $resultado['menssage'] = 'El destinatario tiene como referencia una persona que no existe';
                    throw new Exception(json_encode($resultado['menssage']));
                }
                
                $resultado['persona'] = $personaForm->mostrarPersonaConLugarYEstudios();
                $resultado['destinatario'] = $model->toArray();

            }else{
                $resultado['menssage'] = 'El Destinatario no existe!';
                throw new Exception(json_encode($resultado['menssage']));
            }
        
        return $resultado;
            
        }catch(Exception $exc){
        
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(500, $mensaje);
        }
        
        
        
    }
    
    
    /**
     * Se recibe el modelo Destinatario para crear un array con sus registros, con el fin de ser modificados
     * @param Destinatario $model
     * @return array $resultado
     */
    private function crearVistaModeloModificar($model){
        
        
        try{
            $resultado = array();
            
            if($model!=null){
                
                #####Instanceamos la persona a mostrar
                $personaForm = new PersonaForm();
                $personaForm->buscarPersonaPorIdEnRegistral($model->personaid);
                
                if(!isset($personaForm->id)){
                    $resultado['menssage'] = 'El destinatario tiene como referencia una persona que no existe';
                    throw new Exception(json_encode($resultado['menssage']));
                }
                
                $resultado['persona'] = $personaForm->mostrarPersonaConLugarYEstudios();
                unset($resultado['persona']['sexo']);
                unset($resultado['persona']['genero']);
                unset($resultado['persona']['estado_civil']);
                
                
                $resultado['destinatario'] = $model->toArray();
                unset($resultado['destinatario']['oficio']);
                unset($resultado['destinatario']['profesion']);

            }else{
                $resultado['menssage'] = 'El Destinatario no existe!';
                    throw new Exception(json_encode($resultado['menssage']));
            }
        
        return $resultado;
            
        }catch(Exception $exc){
        
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(500, $mensaje);
        }
        
        
        
    }
}