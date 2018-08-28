<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;

/**Models**/
use app\models\AmbienteTrabajo;

class ProfesionController extends ActiveController{
    
    public $modelClass = 'app\models\Profesion';
    
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
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
//        unset($actions['create']);
        return $actions;
    
    }
    
    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\ProfesionSearch();
//        return $searchModel->busquedadGeneral(\Yii::$app->request->queryParams);
        $resultado = $searchModel->busquedadGeneral(\Yii::$app->request->queryParams);
        
        $data = array('estado'=>false);
        if($resultado->getTotalCount()){
            $data['estado']='true';            
            $data['resultado']=$resultado->models;
        }

        return $data;
    }   
    
    /**
     * Se crea un Destinatario y se vincula con una Persona()
     * @return array Un array con datos
     * @throws \yii\web\HttpException
     */
    public function actionCreate()
    {
//        $resultado['message']='Se guarda un Oficio';
//        $param = Yii::$app->request->post();
//        $transaction = Yii::$app->db->beginTransaction();
//        try {
//            
//            $model = new AmbienteTrabajo();
//            $model->setAttributes($param);
//            //Registrar y validar personaid
//            
//            
//            $transaction->commit();
//            
//            $resultado['success']=true;
//            $resultado['data']['id']=$model->personaid;
//            
//            return  $resultado;
//           
//        }catch (Exception $exc) {
//            //echo $exc->getTraceAsString();
//            $transaction->rollBack();
//            $mensaje =$exc->getMessage();
//            throw new \yii\web\HttpException(500, $mensaje);
//        }

    }
}