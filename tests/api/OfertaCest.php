<?php
use Helper\Api;
//use app\models\Oferta;

class OfertaCest
{
    public function _before(ApiTester $I,Api $api)
    {
        $I->wantTo('Login');
        $token = $api->generarToken();
        $I->amBearerAuthenticated($token);
    }

    public function _fixtures()
    {
        return [
            'ofertas' => app\tests\fixtures\OfertaFixture::className(),
        ];
    }
    
    public function _after(ApiTester $I)
    { 
//        $I->unloadFixtures([new  app\tests\fixtures\OfertaFixture]);
    }
    
    public function crearOfertaConCampoVacios(ApiTester $I)
    {
        $I->wantTo('Agregar una oferta con campos vacios');
        $params=[];
        
        $I->sendPOST('/api/ofertas', $params);
        
        $I->seeResponseContainsJson([            
            'message' => '{'
            . '"lugar":{'
                . '"calle":["Calle no puede estar vac\u00edo."],'
                . '"altura":["Altura no puede estar vac\u00edo."],'
                . '"localidadid":["Localidadid no puede estar vac\u00edo."]},'
            . '"oferta":{'
                . '"ambiente_trabajoid":["Ambiente Trabajoid no puede estar vac\u00edo."],'
                . '"puesto":["Puesto no puede estar vac\u00edo."],'
                . '"demanda_laboral":["Demanda Laboral no puede estar vac\u00edo."],'
                . '"lugarid":["Lugarid no puede estar vac\u00edo."]}}'
        ]);
        
        $I->seeResponseCodeIs(500);
        
    }
    
    public function crearOfertaConLocalidadIdInvalido(ApiTester $I)
    {
        $I->wantTo('Agregar una oferta con localidadid invalido');
        $params=[
            "ambiente_trabajoid"=> 1,
            "nombre_sucursal"=> "Sucursal 1 - Paderia Mitre Modificado",
            "puesto"=> "cajera otro",
            "area"=>"nueva area",
            "fecha_final"=> "",
            "demanda_laboral"=> "Falta dividir responsabilidades",
            "objetivo"=> "Poder dar una oportunidad de trabajo",
            "dia_horario"=> "lunes a viernes 10 a 12:30",
            "lugar"=> [
                "calle"=>"algo",
                "altura"=>"1234",
                "localidadid"=>0
            ],
            "tarea"=> "tareas de cajera"
        ];
        
        $I->sendPOST('/api/ofertas', $params);
        
        $I->seeResponseContainsJson([            
            'message' => '{"lugar":{"id":["La localidad con el id  no existe!"]},"oferta":{"lugarid":["Lugarid no puede estar vac\u00edo."]}}'
        ]);
        
        $I->seeResponseCodeIs(500);
        
    }
    
    public function crearOferta(ApiTester $I)
    {
        $I->wantTo('Agregar una oferta');
        $params=[
            "ambiente_trabajoid"=> 1,
            "nombre_sucursal"=> "Sucursal 1 - Paderia Mitre Modificado",
            "puesto"=> "cajera otro",
            "area"=>"nueva area",
            "fecha_final"=> "",
            "demanda_laboral"=> "Falta dividir responsabilidades",
            "objetivo"=> "Poder dar una oportunidad de trabajo",
            "dia_horario"=> "lunes a viernes 10 a 12:30",
            "lugar"=> [
                "calle"=>"algo",
                "altura"=>"1234",
                "localidadid"=>1
            ],
            "tarea"=> "tareas de cajera"
        ];
        
        $I->sendPOST('/api/ofertas', $params);
        
        $I->seeResponseContainsJson([            
            'message' => 'Se registra una Oferta'
        ]);
        
        $I->seeResponseCodeIs(200);
        
    }
    
    public function modificarOferta(ApiTester $I)
    {
        $I->wantTo('Modificar una oferta');
        $params=[
            "ambiente_trabajoid"=> 1,
            "nombre_sucursal"=> "Sucursal 1 - Paderia Mitre Modificado",
            "puesto"=> "cajera otro",
            "area"=>"nueva area",
            "fecha_final"=> "",
            "demanda_laboral"=> "Falta dividir responsabilidades",
            "objetivo"=> "Poder dar una oportunidad de trabajo",
            "dia_horario"=> "lunes a viernes 10 a 12:30",
            "lugar"=> [
                "calle"=>"algo",
                "altura"=>"1234",
                "localidadid"=>1
            ],
            "tarea"=> "tareas de cajera"
        ];
        
        $I->sendPUT('/api/ofertas/1', $params);
        
        $I->seeResponseContainsJson([            
            'message' => 'Se guarda una Oferta'
        ]);
        
        $I->seeResponseCodeIs(200);
        
    }
}
