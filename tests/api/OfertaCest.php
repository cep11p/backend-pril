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
            "fecha_inicial" => '2018-09-13 09:34:45',
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
   
    public function ListaOferta(ApiTester $I)
    {
        $I->wantTo('Lista de ofertas');
        
        $I->sendGET('/api/ofertas');
        
        $I->seeResponseContainsJson([            
            "total_filtrado"=> 5,
            "success"=> true,
            "resultado"=> [
                [
                    "id"=> 1,
                    "ambiente_trabajoid"=> 1,
                    "nombre_sucursal"=> "Sucursal 1 - Paderia Mitre Modificado",
                    "puesto"=> "cajera otro",
                    "area"=> "nueva area",
                    "fecha_inicial"=> '2018-10-13 10:34:45',
                    "fecha_final"=> null,
                    "demanda_laboral"=> "Falta dividir responsabilidades",
                    "objetivo"=> "Poder dar una oportunidad de trabajo",
                    "lugarid"=> 1,
                    "lugar"=> [
                        "id"=> 1,
                        "nombre"=> "",
                        "barrio"=> "Don bosco",
                        "calle"=> "Mitre",
                        "altura"=> "327",
                        "piso"=> "A",
                        "depto"=> "",
                        "escalera"=> "",
                        "localidadid"=> 1,
                        "latitud"=> "-123123",
                        "longitud"=> "321123"
                    ],
                    "ambiente_trabajo"=> "Panaderia San Fernando"
                ],
                [
                    "id"=> 2,
                    "ambiente_trabajoid"=> 1,
                    "nombre_sucursal"=> "Sucursal Nº 2",
                    "puesto"=> "cajera",
                    "area"=> "",
                    "fecha_inicial"=> '2018-09-10 17:34:45',
                    "fecha_final"=> null,
                    "demanda_laboral"=> "falta una cajera",
                    "objetivo"=> "conseguir personal especificamente para la caja",
                    "lugarid"=> 2,
                    "lugar"=> [
                        "id"=> 2,
                        "nombre"=> "",
                        "barrio"=> "Ina Lauquen",
                        "calle"=> "Saavedra",
                        "altura"=> "321",
                        "piso"=> "",
                        "depto"=> "",
                        "escalera"=> "",
                        "localidadid"=> 1,
                        "latitud"=> "-123321",
                        "longitud"=> "321321"
                    ],
                    "ambiente_trabajo"=> "Panaderia San Fernando"
                ],
                [
                    "id"=> 3,
                    "ambiente_trabajoid"=> 1,
                    "nombre_sucursal"=> "Sucursal Nº 2",
                    "puesto"=> "Limipieza",
                    "area"=> "",
                    "fecha_inicial"=> '2018-09-13 09:34:45',
                    "fecha_final"=> null,
                    "demanda_laboral"=> "falta mantenimiento en la sucursal",
                    "objetivo"=> "conseguir personal especificamente para limpieza",
                    "lugarid"=> 2,
                    "lugar"=> [
                        "id"=> 2,
                        "nombre"=> "",
                        "barrio"=> "Ina Lauquen",
                        "calle"=> "Saavedra",
                        "altura"=> "321",
                        "piso"=> "",
                        "depto"=> "",
                        "escalera"=> "",
                        "localidadid"=> 1,
                        "latitud"=> "-123321",
                        "longitud"=> "321321"
                    ],
                    "ambiente_trabajo"=> "Panaderia San Fernando"
                ],
                [
                    "id"=> 4,
                    "ambiente_trabajoid"=> 2,
                    "nombre_sucursal"=> "Sucursal Nº 1",
                    "puesto"=> "Limipieza",
                    "area"=> "",
                    "fecha_inicial"=> '2019-09-16 16:03:49',
                    "fecha_final"=> null,
                    "demanda_laboral"=> "falta mantenimiento en la sucursal",
                    "objetivo"=> "conseguir personal especificamente para limpieza",
                    "lugarid"=> 3,
                    "lugar"=> [
                        "id"=> 3,
                        "nombre"=> "",
                        "barrio"=> "Don bosco",
                        "calle"=> "Mitre",
                        "altura"=> "327",
                        "piso"=> "2",
                        "depto"=> "A",
                        "escalera"=> "",
                        "localidadid"=> 1,
                        "latitud"=> "-123123",
                        "longitud"=> "321123"
                    ],
                    "ambiente_trabajo"=> "Panaderia Boomble"
                ],
                [
                    "id"=> 5,
                    "ambiente_trabajoid"=> 1,
                    "nombre_sucursal"=> "Sucursal 1 - Paderia Mitre Modificado",
                    "puesto"=> "cajera otro",
                    "area"=> "nueva area",
                    "fecha_final"=> null,
                    "demanda_laboral"=> "Falta dividir responsabilidades",
                    "objetivo"=> "Poder dar una oportunidad de trabajo",
                    "lugarid"=> 1,
                    "lugar"=> [
                        "id"=> 1,
                        "nombre"=> "",
                        "barrio"=> "Don bosco",
                        "calle"=> "Mitre",
                        "altura"=> "327",
                        "piso"=> "A",
                        "depto"=> "",
                        "escalera"=> "",
                        "localidadid"=> 1,
                        "latitud"=> "-123123",
                        "longitud"=> "321123"
                    ],
                    "ambiente_trabajo"=> "Panaderia San Fernando"
                ]
            ]
        ]);
        
        $I->seeResponseCodeIs(200);
        
    }
}
