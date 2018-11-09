<?php

namespace app\tests\fixtures;
use yii\test\ActiveFixture;

class OfertaFixture extends ActiveFixture{
    
    public $modelClass = '\app\models\Oferta';
    public $depends = ['app\tests\fixtures\AmbienteTrabajoFixture']; 
    
    public function init() {
        $this ->dataFile = \Yii::getAlias('@app').'/tests/_data/oferta.php';
        parent::init();
    }
    
    public function unload()
    {
        parent::unload();
        $this->resetTable();
    }
    
}

