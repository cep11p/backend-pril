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
//        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    
    }
    
//    public function prepareDataProvider() 
//    {
//        $searchModel = new \app\models\AmbienteTrabajoSearch();
//        $resultado = $searchModel->busquedadGeneral(\Yii::$app->request->queryParams);
//        $total = Yii::$app->db->createCommand('SELECT COUNT(*) FROM ambiente_trabajo')->queryScalar();
//        
//        $data = array('success'=>false);
//        if($resultado->getTotalCount()){
//            $data['success']='true';
//            $data['total_filtrado']=$resultado->totalCount;            
//            $data['total_general']=intval($total);    
//            $data['coleccion']=$resultado->models;
//        } else {
//            $data['mesagge'] = "No se encontró ningun Ambiente de trabajo!";
//        }
//
//        return $data;
//    }
    
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
            $personaForm = new PersonaForm();
            $oferta = new Oferta();
            
            
            
            /************ Validamos y Guardamos el Area de entrenamiento************/
            $model->setAttributes($param);
            $model->fecha_inicial = date("Y-m-d H:i:s");
            
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
}