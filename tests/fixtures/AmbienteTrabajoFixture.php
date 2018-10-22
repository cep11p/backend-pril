<?php

namespace app\tests\fixtures;
use yii\test\ActiveFixture;

class AmbienteTrabajoFixture extends ActiveFixture{
    
    public $modelClass = '\app\models\AmbienteTrabajo';
    
    public function init() {
        $this ->dataFile = \Yii::getAlias('@app').'/tests/_data/ambiente_trabajo.php';
        parent::init();
    }
    
    public function unload()
    {
        parent::unload();
        $this->resetTable();
    }
    
}

