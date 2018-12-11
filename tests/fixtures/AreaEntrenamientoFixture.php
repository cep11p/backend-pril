<?php

namespace app\tests\fixtures;
use yii\test\ActiveFixture;

class AreaEntrenamientoFixture extends ActiveFixture{
    
    public $modelClass = '\app\models\AreaEntrenamiento';
    public $depends = ['app\tests\fixtures\OfertaFixture']; 
    
    public function init() {
        $this ->dataFile = \Yii::getAlias('@app').'/tests/_data/area_entrenamiento.php';
        parent::init();
    }
    
    public function unload()
    {
        parent::unload();
        $this->resetTable();
    }
    
}

