<?php

namespace app\tests\fixtures;
use yii\test\ActiveFixture;

class DestinatarioFixture extends ActiveFixture{
    
    public $modelClass = '\app\models\Destinatario';
    
    public function init() {
        $this ->dataFile = \Yii::getAlias('@app').'/tests/_data/destinatario.php';
        parent::init();
    }
    
    public function unload()
    {
        parent::unload();
        $this->resetTable();
    }
    
}

