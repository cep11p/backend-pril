<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use Yii;
use yii\base\Exception;
/**Models**/
use app\models\Destinatario;

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
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    
    }
    
    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\DestinatarioSearch();
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
            throw new \yii\web\HttpException(400, $mensaje);
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
     * Vamos a detallar los datos de un destinatario
     * @param int $id
     * @return array json
     * @throws \yii\web\HttpException
     */
    public function actionView($id)
    {        
        $model = Destinatario::findOne(['id'=>$id]);
        if($model){
            $resultado = $model->toArray();
            $persona = $model->getPersona();
            
            #vinculamos el lugar a la persona
            if(count($persona)<1){
                throw new \yii\web\HttpException(404, "No se encuentra la persona {$resultado['personaid']}, que está vinculada con el Desintario!!");
            }
            
            $resultado['persona'] = $persona;
        }else{
            throw new \yii\web\HttpException(400, "El destinatario no existe!");
        }        
        
        return $resultado;

    }
    
}