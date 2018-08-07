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

    public function rules()
    {
        return [
            [['nivel_educativoid', 'personaid'], 'required'],
            [['nivel_educativoid', 'completo', 'en_curso', 'personaid'], 'integer'],
            [['fecha'], 'date', 'format' => 'php:Y-m-d'],
            [['titulo'], 'string', 'max' => 200]
        ];
    }
    
    
    
   
}
