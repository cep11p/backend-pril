<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "persona".
 */
class HogarForm extends Model
{
    public $id;
    public $barrio;
    public $calle;
    public $altura;
    public $piso;
    public $depto;
    public $localidadid;
    public $jefeid;

    public function rules()
    {
        return [
            [['calle', 'altura', 'localidadid'], 'required'],
            [['localidadid', 'jefeid','id'], 'integer'],
            [['barrio'], 'string', 'max' => 100],
            [['calle', 'altura', 'piso', 'depto'], 'string', 'max' => 45],
        ];
    }
    
    
    
   
}
