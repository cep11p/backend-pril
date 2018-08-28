<?php

use app\models\PersonaForm;
class PersonaFormTest extends \Codeception\Test\Unit
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

    // tests
    public function testDisparaExcepcionSiPersonaNoExiste()
    {
//        $msj = 'un mensaje peroooooo';
//        $this->tester->expectException(new \yii\base\Exception($msj),function(){
//            $param=[
//                "id"=>0,
//                "nombre"=>"Carlos",
//                "apodo"=>"Kar",
//                "apellido"=>"Lopez",
//                "nro_documento"=>"36765567",
//                "fecha_nacimiento"=>"07/05/1995",
//                "estado_civilid"=>"1",
//                "telefono"=>"",
//                "celular"=>"(2920) 15412228",
//                "sexoid"=>"1",
//                "tipo_documentoid"=>1,
//                "nucleoid"=>null,
//                "situacion_laboralid"=>1,
//                "generoid"=>1,
//                "email"=>"uncorre@hotmail.com",
//            ];
//            $model = new PersonaForm;
//            $model->setAttributes($param);
//            $model->save();
//        });

    }
}