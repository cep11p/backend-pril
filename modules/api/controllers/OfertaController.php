<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use Yii;
use yii\base\Exception;

use \yii\helpers\ArrayHelper;

use app\models\Oferta;
use app\models\LugarForm;

class OfertaController extends ActiveController{
    
    public $modelClass = 'app\models\Oferta';
    
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
     * Se crea una Oferta y se vincula con un AmbienteTrabajo()
     * @return array Un array con datos
     * @throws \yii\web\HttpException
     */
    public function actionCreate()
    {
        $resultado['message']='Se registra una Oferta';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        $arrayErrors = array();
        try {
            
            $model = new Oferta();
            $lugarForm = new LugarForm();
            
            /************ Validamos todos los campos de Lugar************/
            if(isset($param['lugar'])){
                $lugarForm->setAttributes($param['lugar']);
            }
            
            if(!$lugarForm->save()){
                $arrayErrors = ArrayHelper::merge($arrayErrors, array('lugar' => $lugarForm->getErrors()));
            }         
            
            /************ Validamos todos los campos de Oferta************/
            $model->setAttributes($param);
            $model->lugarid = $lugarForm->id;
            $model->fecha_inicial = date("Y-m-d H:i:s");
            
            if(!$model->validate()){ 
                $arrayErrors = ArrayHelper::merge($arrayErrors, array("oferta" => $model->getErrors()));
            }         
            
            /*********** Fin de la Validacion******/
            
            //verificamos si hay errores para mostrar
            if(count($arrayErrors)>0){
                throw new Exception(json_encode($arrayErrors));
            }
            
            
            
            if(!$model->save()){
                $arrayErrors['oferta']=$model->getErrors();                
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
    
    
}