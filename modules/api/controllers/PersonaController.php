<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use Yii;
use yii\base\Exception;
/**Models**/
//use app\models\Destinatario;

class PersonaController extends ActiveController{
    
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
        unset($actions['index']);
        unset($actions['update']);
        unset($actions['view']);
        return $actions;
    
    }
    
   
    
    public function actionIndex()
    {
        $resultado['estado']=false;
        $param = Yii::$app->request->queryParams;
        
        
        $resultado = \Yii::$app->registral->buscarPersona($param);
        
        if($resultado['estado']!=true){
            $data['success']=false;            
            $data['resultado']=[];
            $data['message']="No se encontró ninguna persona!";   
        }else{
            $data['success']=true;
            $data['resultado']=$resultado['resultado'];
        }
        
        return $data;

    }
    
    /**
     * Se busca una persona por numero documento, y se devuelve una sola persona
     * @param type $nro_documento
     * @Method GET
     * @url ejemplo http://api.pril.local/api/personas/buscar-por-documento/29800100
     * @return array
     */
    public function actionBuscarPorDocumento($nro_documento)
    {
        $resultado['estado']=false;   
        $resultado = \Yii::$app->registral->buscarPersonaPorNroDocumento($nro_documento);
        
//        print_r($resultado);die();
        
        $data = array();
        if(count($resultado)>0){
            $data = $resultado;
        }
        
        return $data;

    }
}