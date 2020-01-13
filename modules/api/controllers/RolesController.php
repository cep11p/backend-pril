<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;

class RolesController extends ActiveController{
    
    public $modelClass = 'app\models\Role';
    
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
//        unset($actions['index']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['update']);
        unset($actions['view']);
        return $actions;
    
    }
    
    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\RolesSearch();
        $resultado = $searchModel->search(\Yii::$app->request->queryParams);
        
        return $resultado;
    }
    
}