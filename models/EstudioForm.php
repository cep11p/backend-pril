<?php

namespace app\models;


use yii\helpers\ArrayHelper;
use Yii;
use yii\console\Exception;
use app\models\Estudio;
use yii\base\Model;

/**
 * This is the model class for table "persona".
 */
class EstudioForm extends Model
{
    public $nivel_educativoid;
    public $titulo;
    public $completo;
    public $en_curso;
    public $fecha;
    public $personaid;

    public function rules()
    {
        return [
            [['nivel_educativoid'], 'required'],
            [['nivel_educativoid', 'completo', 'en_curso', 'personaid'], 'integer'],
            [['fecha'], 'date', 'format' => 'php:Y-m-d'],
            [['titulo'], 'string', 'max' => 200],
            ['nivel_educativoid','existeNivelEducativoEnRegistral']
        ];
    }
    
    public function existeNivelEducativoEnRegistral(){
        $response = \Yii::$app->registral->buscarNivelEducativoPorId($this->nivel_educativoid);       
//        print_r($response);die();
        if(isset($response['estado']) && $response['estado']!=true){
            $this->addError('nivel_educativoid', 'El nivel educativo con el id '.$this->nivel_educativoid.' no existe!');
        }
    }
    
    
    
   
}
