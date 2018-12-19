<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use Yii;

/**Models**/
use app\models\AreaEntrenamiento;
use app\models\Oferta;
use app\models\PersonaForm;
use \yii\helpers\ArrayHelper;
use yii\base\Exception;

class AreaEntrenamientoController extends ActiveController{
    
    public $modelClass = 'app\models\AreaEntrenamiento';
    
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
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    
    }
    
    public function prepareDataProvider() 
    {        
        $searchModel = new \app\models\AreaEntrenamientoSearch();
        $resultado = $searchModel->busquedadGeneral(\Yii::$app->request->queryParams);

        return $resultado;
    }
    
    /**
     * Se crea un Area de entrenamiento que se vincula con una Persona() y una Oferta()
     * @return array Un array con datos
     * @throws \yii\web\HttpException
     */
    public function actionCreate()
    {
        $resultado['message']='Se registra un Area de entrenamiento';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        $arrayErrors = array();
        try {
            
            $model = new AreaEntrenamiento();
            
            /************ Validamos y Guardamos el Area de entrenamiento************/
            $model->setAttributes($param);
            
            if(isset($param['fecha_inicial']) && !empty($param['fecha_inicial'])){
                $model->fecha_inicial = Yii::$app->formatter->asDatetime($param['fecha_inicial'] .' 03:00:00', 'php:Y-m-d H:i:s');
            }else{
                $model->fecha_inicial = date("Y-m-d H:i:s");
            }
            
            
            if(!$model->save()){
                $arrayErrors=$model->getErrors();                
                throw new Exception(json_encode($arrayErrors));
            }
            
            #verificamos si hay errores para mostrar
            if(count($arrayErrors)>0){
                throw new Exception(json_encode($arrayErrors));
            }
            /*********** Fin de la Validacion******/
            
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
     * Se modifica un Area de entrenamiento que se vincula con una Persona() y una Oferta()
     * @return array Un array con datos
     * @throws \yii\web\HttpException
     */
    public function actionUpdate($id)
    {
        $resultado['message']='Se modifica el Area de entrenamiento';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        $arrayErrors = array();
        try {
            
            $model = AreaEntrenamiento::findOne(['id'=>$id]); 
            if($model==NULL){
                $msj = 'El area de entrenamiento con el id '.$id.' no existe!';
                throw new Exception($msj);
            }
            
            /************ Validamos y Guardamos el Area de entrenamiento************/
            $model->setAttributes($param);
            
            if(!$model->save()){
                $arrayErrors=$model->getErrors();                
                throw new Exception(json_encode($arrayErrors));
            }
            
            #verificamos si hay errores para mostrar
            if(count($arrayErrors)>0){
                throw new Exception(json_encode($arrayErrors));
            }
            /*********** Fin de la Validacion******/
            
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
    
    public function actionView($id)
    {        
        $model = AreaEntrenamiento::findOne(['id'=>$id]);
        if($model){
            $resultado = $model->toArray();
            $oferta = $model->oferta->toArray();
            $destinatario = $model->destinatario->toArray();
            $destinatario['persona'] = $model->destinatario->persona;
            $ambiente_trabajo = $model->oferta->ambienteTrabajo;
            $representante = $ambiente_trabajo->persona;
            
            #chequeamos si existe la oferta
            if(count($oferta)<1){
                throw new \yii\web\HttpException(404, "No se encuentra la oferta {$resultado['ofertaid']}, que se vincula con el Area de entrenamiento!!");
            }
            
            #chequeamos si existe la persona (representante del ambiente de trabajo)
            if(count($destinatario)<1){
                throw new \yii\web\HttpException(404, "No se encuentra el destinatario {$resultado['destinatarioid']}, que se vincula con el area de entrenamiento!!");
            }
            
            #chequeamos si existe el ambiente de trabajo
            if(count($ambiente_trabajo)<1){
                throw new \yii\web\HttpException(404, "No se encuentra el ambiente de trabajo {$oferta['ambiente_trabajoid']}, que se vincula con la oferta!!");
            }
            
            #chequeamos si existe el representante del ambiente de trabajo
            if(!isset($representante)){
                throw new \yii\web\HttpException(404, "No se encuentra el representante {$ambiente_trabajo['personaid']}, que se vincula con el ambiente de trabajo {$ambiente_trabajo['nombre']}!!");
            }
            
            $resultado['destintario'] = $destinatario;            
            $resultado['oferta'] = $oferta;
            unset($resultado['oferta']['ambiente_trabajo']);
            $resultado['ambiente_trabajo']["nombre"] = $ambiente_trabajo->nombre;
            $resultado['ambiente_trabajo']["cuit"] = $ambiente_trabajo->cuit;
            $resultado['ambiente_trabajo']["legajo"] = $ambiente_trabajo->legajo;
            
            $representante = $ambiente_trabajo->persona;
            $resultado['ambiente_trabajo']["persona"]['nombre'] = $representante['nombre'];
            $resultado['ambiente_trabajo']["persona"]['apellido'] = $representante['apellido'];
            $resultado['ambiente_trabajo']["persona"]['nro_documento'] = $representante['nro_documento'];
            $resultado['ambiente_trabajo']["persona"]['telefono'] = $representante['telefono'];
            $resultado['ambiente_trabajo']["persona"]['celular'] = $representante['celular'];
            $resultado['ambiente_trabajo']["persona"]['email'] = $representante['email'];
            
        }else{
            throw new \yii\web\HttpException(400, "El ambiente de trabajo no existe!");
        }        
        
        return $resultado;

    }
}