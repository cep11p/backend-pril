<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "persona".
 */
class NucleoForm extends Model
{
    public $id;
    public $nombre;
    public $hogarid;
    public $jefeid;

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['jefeid', 'hogarid'], 'integer'],
            [['nombre'], 'string', 'max' => 100]
        ];
    }
    
    
    
   
}
