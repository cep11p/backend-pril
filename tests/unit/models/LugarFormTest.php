<?php

class LugarFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    
    public function testBuscarLugarEnSistemaLugar()
    {
        $param = [
                    "nombre"=>"",
                    "barrio"=>"Don bosco",
                    "calle"=>"Mitre",
                    "altura"=>"327",
                    "piso"=>"A",
                    "depto"=>"",
                    "escalera"=>"",
                    "localidadid"=>1,
                    "latitud"=>"-123123",
                    "longitud"=>"321123"
                ];
        $model = new app\models\LugarForm;
        $model->setAttributes($param);
        
        $param['id'] = 1;
        
        $this->assertJsonStringEqualsJsonString(json_encode($param), json_encode($model->buscarLugarEnSistemaLugar()));
    }
    
    public function testSiExisteLocalidadEnSistemaLugarRetornaTrue()
    {
        $param = [
                    "nombre"=>"",
                    "barrio"=>"Don bosco",
                    "calle"=>"Mitre",
                    "altura"=>"327",
                    "piso"=>"A",
                    "depto"=>"",
                    "escalera"=>"",
                    "localidadid"=>99,
                    "latitud"=>"-123123",
                    "longitud"=>"321123"
                ];
        $model = new app\models\LugarForm;
        $model->setAttributes($param);
        
        
        $this->assertFalse($model->validate());
    }
}