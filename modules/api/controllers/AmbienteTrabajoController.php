<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use Yii;

/**Models**/
use app\models\AmbienteTrabajo;
use app\models\LugarForm;
use app\models\PersonaForm;
use \yii\helpers\ArrayHelper;
use yii\base\Exception;

class AmbienteTrabajoController extends ActiveController{
    
    public $modelClass = 'app\models\AmbienteTrabajo';
    
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
        unset($actions['view']);
        unset($actions['update']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    
    }
    
    /**
     * Se prepara la coleccion. Si hay criterio se devuelve la coleccion filtrada
     * @return array
     */
    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\AmbienteTrabajoSearch();
        $resultado = $searchModel->busquedadGeneral(\Yii::$app->request->queryParams);
                
        return $resultado;
    }
    
    /**
     * Se crea un Destinatario y se vincula con una Persona()
     * @return array Un array con datos
     * @throws \yii\web\HttpException
     */
    public function actionCreate()
    {
        $resultado['message']='Se guarda un Ambiente de Trabajo';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        $arrayErrors = array();
        try {
            
            $model = new AmbienteTrabajo();
            $lugarForm = new LugarForm();
            $personaForm = new PersonaForm();
            
            /************ Validamos todos los campos de Lugar************/
            if(isset($param['lugar'])){
                $lugarForm->setAttributes($param['lugar']);
            }
            
            if(!$lugarForm->validate()){
                $arrayErrors = ArrayHelper::merge($arrayErrors, array('lugar' => $lugarForm->getErrors()));
            }            
            
            /************ Validamos todos los campos de Representante************/
            if(isset($param['persona'])){
                $personaForm->setAttributes($param['persona']);
            }
            if(!$personaForm->save()){
                $arrayErrors = ArrayHelper::merge($arrayErrors, array('persona' => $personaForm->getErrors()));
            }            
            
            
            /************ Validamos todos los campos de AmbienteTrabajo************/
            $model->setAttributes($param);
            $model->personaid = $personaForm->id;
            
            
            if(!$model->validate()){ 
                $arrayErrors = ArrayHelper::merge($arrayErrors, array('ambiente_trabajo' => $model->getErrors()));
            }           
            
            /*********** Fin de la Validacion******/
            
            //verificamos si hay errores para mostrar
            if(count($arrayErrors)>0){
                throw new Exception(json_encode($arrayErrors));
            }
            
            $lugarid = intval(\Yii::$app->lugar->crearLugar($lugarForm));
            $model->lugarid = $lugarid;
            
            if(!$model->save()){
                $arrayErrors['ambiente_trabajo']=$model->getErrors();                
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
     * Se modifica el ambiente de trabajo
     * @param int $id
     * @return array
     * @throws \yii\web\HttpException
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $resultado['message']='Se modifica un Ambiente de Trabajo';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        $arrayErrors = array();
        try {
            
            $model = AmbienteTrabajo::findOne(["id"=>$id]);
            
            if($model==NULL){
                $msj = 'El ambiente de trabajo con el id '.$id.' no existe!';
                throw new Exception($msj);
            }
            
            $lugarForm = new LugarForm();
            $personaForm = new PersonaForm();
            /************ Validamos todos los campos de Lugar (ambiente de trabajo)************/
            if(isset($param['lugar'])){
                $lugarForm->setAttributes($param['lugar']);
            }
            
            if(!$lugarForm->validate()){
                $arrayErrors = ArrayHelper::merge($arrayErrors, array('lugar' => $lugarForm->getErrors()));
            }            
            
            /************ Validamos todos los campos de Representante************/
            if(isset($param['persona']['id'])){
                $personaForm->buscarPersonaPorIdEnRegistral($param['persona']['id']);
                
                #nos aseguramos que persona exista
                if(!isset($personaForm->id)){
                    $msj = 'La persona con el id '.$param['persona']['id'] .' no existe!';
                    throw new Exception($msj);
                }
                #evitamos que se modifique la persona
                if($personaForm->existeModificacion($param['persona'])){
                    $msj = 'No se permite modificar la persona';
                    throw new Exception($msj);
                }
            #asignamos una persona totalmente nueva    
            }else if(isset($param['persona'])){
                $personaForm->setAttributes($param['persona']);
            }
            
            
            if(!$personaForm->save()){
                $arrayErrors = ArrayHelper::merge($arrayErrors, array('persona' => $personaForm->getErrors()));
            }            
            
            
            /************ Validamos todos los campos de AmbienteTrabajo************/
            $model->setAttributes($param);
            $model->personaid = $personaForm->id;
            
            
            if(!$model->validate()){ 
                $arrayErrors = ArrayHelper::merge($arrayErrors, array('ambiente_trabajo' => $model->getErrors()));
            }           
            
            /*********** Fin de la Validacion******/
            
            //verificamos si hay errores para mostrar
            if(count($arrayErrors)>0){
                throw new Exception(json_encode($arrayErrors));
            }
            
            $lugarid = intval(\Yii::$app->lugar->crearLugar($lugarForm));
            $model->lugarid = $lugarid;
            
            if(!$model->save()){
                $arrayErrors['ambiente_trabajo']=$model->getErrors();                
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
     * Se prepara la vista particular de un ambiente de trabajo
     * @param int $id
     * @return array
     * @throws \yii\web\HttpException
     */
    public function actionView($id)
    {        
        $model = AmbienteTrabajo::findOne(['id'=>$id]);
        if($model){
            $resultado = $model->toArray();
            $lugar = $model->getLugar();
            $persona = $model->getPersona();
            
            #vinculamos el lugar del ambiente de trabajo
            if(count($lugar)<1){
                throw new \yii\web\HttpException(404, "No se encuentra el lugar {$resultado['lugarid']}, que está vinculada con el Ambiente de trabajo!!");
            }
            
            #vinculamos la persona (representante del ambiente de trabajo)
            if(count($persona)<1){
                throw new \yii\web\HttpException(404, "No se encuentra la persona {$resultado['personaid']}, que es el representante del ambiente de trabajo!!");
            }
            
            $resultado['persona'] = $persona;            
            $resultado['lugar'] = $lugar;
        }else{
            throw new \yii\web\HttpException(400, "El ambiente de trabajo no existe!");
        }        
        
        return $resultado;

    }
}