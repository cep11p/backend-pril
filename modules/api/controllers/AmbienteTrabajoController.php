<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use Yii;

/**Models**/
use app\models\AmbienteTrabajo;
use app\models\LugarForm;
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
        return $actions;
    
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
            
            /************ Validamos todos los campos de Lugar************/
            if(isset($param['lugar'])){
                $lugarForm->setAttributes($param['lugar']);
            }
            
            if(!$lugarForm->validate()){
                $arrayErrors = ArrayHelper::merge($arrayErrors, array('lugar' => $lugarForm->getErrors()));
            }
            
            $paramLugar = $lugarForm->toArray();
            
            if(isset($param['lugar']['usarLugarEncontrado']) && $param['lugar']['usarLugarEncontrado']==true){
                if(!isset($paramLugar['id'])){
                    $arrayErrors['lugar']['id']='El atributo id debe estar seteando si se quiere reutilizar el lugar!';                
                    $arrayErrors['tab']='lugar';                
                    throw new Exception(json_encode($arrayErrors));
                }
                $paramLugar['usarLugarEncontrado'] = $param['lugar']['usarLugarEncontrado'];
            }else{
                $lugarForm->existeLugar();                
                if(count($lugarForm->getErrors())>0){
                    $arrayErrors = ArrayHelper::merge($arrayErrors, array('lugar' => $lugarForm->getErrors()));
                }
                
            }
            
            
            /************ Validamos todos los campos de AmbienteTrabajo************/
            if (isset($param['ambiente_trabajo'])){
                $model->setAttributes($param['ambiente_trabajo']);
            }
            
            if(!$model->validate()){ 
                $arrayErrors = ArrayHelper::merge($arrayErrors, array('ambiente_trabajo' => $model->getErrors()));
            }
            
            if(count($arrayErrors)>0){
                throw new Exception(json_encode($arrayErrors));
            }
            /*********** Fin de la Validacion******/
            
            
            $lugarid = intval(\Yii::$app->lugar->crearLugar($paramLugar));
            $model->lugarid = $lugarid;
            
            if(!$model->save()){
                $arrayErrors['ambiente_trabajo']=$model->getErrors();
                $arrayErrors['tab']='ambiente_trabajo';                
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