<?php

use Helper\Api;
use app\models\Destinatario;
date_default_timezone_set ('America/Argentina/Buenos_Aires');

class DestinatarioCest
{
    /**
     *
     * @var Helper\Api
     */    
    protected $api;
    
    public function _before(ApiTester $I,Api $api)
    {
        $I->wantTo('Login');
        $token = $api->generarToken();
        $I->amBearerAuthenticated($token);
    }
    
    public function _fixtures()
    {
        return [
            'destinatarios' => app\tests\fixtures\DestinatarioFixture::className(),
        ];
    }
    
    

    /**
     * @param ApiTester $I
     */
    public function crearDestinatarioSinPersona(ApiTester $I)
    {
        $I->wantTo('Se registra un destinatario sin Persona');
        $param=[
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/1",
		"fecha_presentacion"=>"2000-12-12",
		"origen"=> "un origen test",
		"deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
		"deseo_actividad"=> "La actividad que desea realizar",
		"experiencia_laboral"=> 1,
		"banco_cbu"=> "54321987654",
		"banco_nombre"=> "Patagonia",
		"banco_alias"=> "CAMION-RODILLO-RUEDA",
		"observacion"=> "Una observacion"
            ]
        ];
        
        $I->sendPOST('/api/destinatarios', $param);
        
        $I->seeResponseContainsJson([
            'message' => '{"nombre":["Nombre no puede estar vac\u00edo."],"apellido":["Apellido no puede estar vac\u00edo."],"nro_documento":["Nro Documento no puede estar vac\u00edo."],"fecha_nacimiento":["Fecha Nacimiento no puede estar vac\u00edo."],"estado_civilid":["Estado Civilid no puede estar vac\u00edo."],"sexoid":["Sexoid no puede estar vac\u00edo."],"generoid":["Generoid no puede estar vac\u00edo."],"email":["Email no puede estar vac\u00edo."],"calle":["Calle no puede estar vac\u00edo."],"altura":["Altura no puede estar vac\u00edo."],"localidadid":["Localidadid no puede estar vac\u00edo."]}'
        ]);
        
        $I->seeResponseCodeIs(400);
        
        
    }
    
    /**
     * @param ApiTester $I
     */ 
    public function crearDestinatarioSinDatos(ApiTester $I)
    {
        $I->wantTo('Se registra un destinatario sin Datos');
        $param=[];
        
        $I->sendPOST('/api/destinatarios', $param);
        
        $I->seeResponseContainsJson([
            'message' => '{"destinatario":{"legajo":["Legajo no puede estar vac\u00edo."],"fecha_ingreso":["Fecha Ingreso no puede estar vac\u00edo."],"fecha_presentacion":["Fecha Presentacion no puede estar vac\u00edo."]},"nombre":["Nombre no puede estar vac\u00edo."],"apellido":["Apellido no puede estar vac\u00edo."],"nro_documento":["Nro Documento no puede estar vac\u00edo."],"fecha_nacimiento":["Fecha Nacimiento no puede estar vac\u00edo."],"estado_civilid":["Estado Civilid no puede estar vac\u00edo."],"sexoid":["Sexoid no puede estar vac\u00edo."],"generoid":["Generoid no puede estar vac\u00edo."],"email":["Email no puede estar vac\u00edo."],"calle":["Calle no puede estar vac\u00edo."],"altura":["Altura no puede estar vac\u00edo."],"localidadid":["Localidadid no puede estar vac\u00edo."]}'
        ]);
        
        $I->seeResponseCodeIs(400);
        
        
    }
    
     /**
     * @param ApiTester $I
     */ 
    public function crearDestinatarioConLegajoExistente(ApiTester $I)
    {
        $I->wantTo('Se registra un destinatario con legajo existente');
        $param=[
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/6",
		"fecha_presentacion"=>"2000-12-12",
		"origen"=> "un origen test",
		"deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
		"deseo_actividad"=> "La actividad que desea realizar",
		"experiencia_laboral"=> 1,
		"banco_cbu"=> "54321987654",
		"banco_nombre"=> "Patagonia",
		"banco_alias"=> "CAMION-RODILLO-RUEDA",
		"observacion"=> "Una observacion",
                "persona"=>[
                    "nombre"=> "Pilar",
                    "apellido"=> "Test",
                    "nro_documento"=> "29890123",
                    "fecha_nacimiento"=>"1980-12-12",
                    "apodo"=>"rominochi",
                    "telefono"=> "2920430690",
                    "celular"=> "2920412127",
                    "situacion_laboralid"=> 1,
                    "estado_civilid"=> 1,
                    "sexoid"=> 2,
                    "tipo_documentoid"=> 1,
                    "generoid"=> 1,
                    "email"=>"algo@correo.com.ar",
                    "cuil"=>"20367655678",
                    "estudios"=> [[
                        "nivel_educativoid"=>4,
                        "titulo"=>"tecnico en desarrollo web",
                        "completo"=>1,
                        "en_curso"=>0,
                        "anio"=>"2014"
                    ]],
                    "lugar"=> [
                        "barrio"=>"Don bosco",
                        "calle"=>"Mitre",
                        "altura"=>"327",
                        "piso"=>"A",
                        "depto"=>"",
                        "escalera"=>"",
                        "localidadid"=>1,
                        "latitud"=>"-123123",
                        "longitud"=>"321123"
                    ]

                ]
            ]            
        ];
        
        $I->sendPOST('/api/destinatarios', $param);
        
        $I->seeResponseContainsJson([
            'message' => '{"destinatario":{"legajo":["Legajo \"usb123\/6\" ya ha sido utilizado."]}}'
        ]);
        
        $I->seeResponseCodeIs(400);
        
        
    }
    
    /**
     * @param ApiTester $I
     */
    public function crearDestinatarioConPersonaNueva(ApiTester $I)
    {
        $I->wantTo('Se agrega un Destinatario');
        $param=array(
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/1",
		"fecha_presentacion"=>"2000-12-12",
		"origen"=> "un origen test",
		"deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
		"deseo_actividad"=> "La actividad que desea realizar",
		"experiencia_laboral"=> 1,
		"banco_cbu"=> "54321987654",
		"banco_nombre"=> "Patagonia",
		"banco_alias"=> "CAMION-RODILLO-RUEDA",
		"observacion"=> "Una observacion",
                "persona"=>[
                    "nombre"=> "Pilar",
                    "apellido"=> "Test",
                    "nro_documento"=> "29890123",
                    "fecha_nacimiento"=>"1980-12-12",
                    "telefono"=> "2920430690",
                    "celular"=> "2920412127",
                    "situacion_laboralid"=> 1,
                    "estado_civilid"=> 1,
                    "sexoid"=> 2,
                    "tipo_documentoid"=> 1,
                    "generoid"=> 1,
                    "email"=>"algo@correo.com.ar",
                    "cuil"=>"20367655678",
                    "estudios"=> [
                        ["nivel_educativoid"=>4,"titulo"=>"tecnico en desarrollo web","completo"=>1,"en_curso"=>0,"anio"=>"2014"]
                    ],
                    "lugar"=> [
                        "barrio"=>"Don bosco",
                        "calle"=>"Mitre",
                        "altura"=>"327",
                        "piso"=>"A",
                        "depto"=>"",
                        "escalera"=>"",
                        "localidadid"=>1,
                        "latitud"=>"-123123",
                        "longitud"=>"321123"
                    ]
                ]
            ]
        );
        
        $I->sendPOST('/api/destinatarios', $param);
        
        $I->seeResponseContainsJson([
            'message' => 'Se guarda un Destinatario',
            'success' => true
        ]);
        
        $I->seeResponseCodeIs(200);
        
       
        //chequeamos lo guardado, no se testea la fecha de ingreso, ya que hay diferencia de segundos en chequear y nunca coincide
        $model = Destinatario::findOne(['legajo'=>'usb123/1']);
        $id = $model->id;
        $I->sendGET("/api/destinatarios/$id");
        $I->seeResponseContainsJson([
            'id' => $id,
            'legajo' => 'usb123/1',
            'calificacion' => 7,
            'origen' => 'un origen test',
            'observacion' => 'Una observacion',
            'deseo_lugar_entrenamiento' => 'Donde desea realizar el entrenamiento',
            'deseo_actividad' => 'La actividad que desea realizar',
            'fecha_presentacion' => '2000-12-12',
            'personaid' => 100,
            'banco_cbu' => '54321987654',
            'banco_nombre' => 'Patagonia',
            'banco_alias' => 'CAMION-RODILLO-RUEDA',
            'experiencia_laboral' => 0,
            'conocimientos_basicos' => null,
            "persona"=>[
                'id' => 100,
                'nombre' => 'Pilar',
                'apellido' => 'Test',
                'nro_documento' => '29890123',
                'fecha_nacimiento' => '1980-12-12',
                'telefono' => '2920430690',
                'celular' => '2920412127',
                'situacion_laboralid' => 1,
                'estado_civilid' => 1,
                'sexoid' => 2,
                'tipo_documentoid' => 1,
                'generoid' => 1,
                'email' => 'algo@correo.com.ar',
                'cuil' => '20367655678',
                "lugar"=> [
                    "id"=> 6,
                    "barrio"=> "Ceferino(1016)",
                    "calle"=> "Guatemala",
                    "altura"=> "212",
                    "piso"=> "",
                    "depto"=> "",
                    "escalera"=> "",
                    "localidadid"=> 1,
                    "localidad"=> "nombreDeLocalidad"
                ]
            ],
        ]);
        $I->seeResponseCodeIs(200);        
        
    }
 
     /**
     * @param ApiTester $I
     */
    public function crearDestinatarioConPersonaExistente(ApiTester $I)
    {
        $I->haveFixtures([
            'destinatarios' => app\tests\fixtures\DestinatarioFixture::className(),
        ]);        
        $I->wantTo('Se agrega un Destinatario con persona existente');
        $param=[
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/1",
		"fecha_presentacion"=>"2000-12-12",
		"origen"=> "un origen test",
		"deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
		"deseo_actividad"=> "La actividad que desea realizar",
		"experiencia_laboral"=> 1,
		"banco_cbu"=> "54321987654",
		"banco_nombre"=> "Patagonia",
		"banco_alias"=> "CAMION-RODILLO-RUEDA",
		"observacion"=> "Una observacion",
                "persona"=>[
                    "id"=>2,
                    "nombre"=> "Pilar",
                    "apellido"=> "Test",
                    "nro_documento"=> "29890124",
                    "fecha_nacimiento"=>"1980-12-12",
                    "telefono"=> "2920430690",
                    "celular"=> "2920412127",
                    "situacion_laboralid"=> 1,
                    "estado_civilid"=> 1,
                    "sexoid"=> 2,
                    "tipo_documentoid"=> 1,
                    "generoid"=> 1,
                    "email"=>"algo@correo.com.ar",
                    "cuil"=>"20367655678",
                    "estudios"=> [[
                        "nivel_educativoid"=>4,
                        "titulo"=>"tecnico en desarrollo web",
                        "completo"=>1,
                        "en_curso"=>0,
                        "anio"=>"2014"
                    ]],
                    "lugar"=> [
                        "barrio"=>"Don bosco",
                        "calle"=>"Mitre",
                        "altura"=>"327",
                        "piso"=>"A",
                        "depto"=>"",
                        "escalera"=>"",
                        "localidadid"=>1,
                        "latitud"=>"-123123",
                        "longitud"=>"321123"
                    ]

                ]
            ]
            
        ];
        
        $I->sendPOST('/api/destinatarios', $param);
        
        $I->seeResponseContainsJson([
            'message' => 'Se guarda un Destinatario',
            'success' => true
        ]);
        
        $I->seeResponseCodeIs(200);
        
       
        //chequeamos lo guardado, no se testea la fecha de ingreso, ya que hay diferencia de segundos en chequear y nunca coincide
        $model = Destinatario::findOne(['legajo'=>'usb123/1']);
        $id = $model->id;
        $I->sendGET("/api/destinatarios/$id");
        $I->seeResponseContainsJson([
            'id' => $id,
            'legajo' => 'usb123/1',
            'calificacion' => 7,
            'origen' => 'un origen test',
            'observacion' => 'Una observacion',
            'deseo_lugar_entrenamiento' => 'Donde desea realizar el entrenamiento',
            'deseo_actividad' => 'La actividad que desea realizar',
            'fecha_presentacion' => '2000-12-12',
            'personaid' => 100,
            'banco_cbu' => '54321987654',
            'banco_nombre' => 'Patagonia',
            'banco_alias' => 'CAMION-RODILLO-RUEDA',
            'experiencia_laboral' => 0,
            'conocimientos_basicos' => null,
            "persona"=>[
                'id' => 100,
                'nombre' => 'Pilar',
                'apellido' => 'Test',
                'nro_documento' => '29890123',
                'fecha_nacimiento' => '1980-12-12',
                'telefono' => '2920430690',
                'celular' => '2920412127',
                'situacion_laboralid' => 1,
                'estado_civilid' => 1,
                'sexoid' => 2,
                'tipo_documentoid' => 1,
                'generoid' => 1,
                'email' => 'algo@correo.com.ar',
                'cuil' => '20367655678',
                "lugar"=> [
                    "id"=> 6,
                    "barrio"=> "Ceferino(1016)",
                    "calle"=> "Guatemala",
                    "altura"=> "212",
                    "piso"=> "",
                    "depto"=> "",
                    "escalera"=> "",
                    "localidadid"=> 1,
                    "localidad"=> "nombreDeLocalidad"
                ]
            ],
        ]);
        $I->seeResponseCodeIs(200);        
        
    }
    
    
     /**
     * @param ApiTester $I
     */
    public function modificarDestinatario(ApiTester $I)
    {
        $I->haveFixtures([
            'destinatarios' => app\tests\fixtures\DestinatarioFixture::className(),
        ]);
        $I->wantTo('Se modifica un Destinatario con persona mock');
        $param=[
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/1",
		"fecha_presentacion"=>"2000-12-12",
		"origen"=> "un origen test modificado",
		"deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
		"deseo_actividad"=> "La actividad que desea realizar",
		"experiencia_laboral"=> 1,
		"banco_cbu"=> "54321987654",
		"banco_nombre"=> "Patagonia",
		"banco_alias"=> "CAMION-RODILLO-RUEDA",
		"observacion"=> "Una observacion",
                "persona"=>[
                    "nombre"=> "Pilar",
                    "apellido"=> "Test",
                    "nro_documento"=> "29890123",
                    "fecha_nacimiento"=>"1980-12-12",
                    "apodo"=>"rominochi",
                    "telefono"=> "2920430690",
                    "celular"=> "2920412127",
                    "situacion_laboralid"=> 1,
                    "estado_civilid"=> 1,
                    "sexoid"=> 2,
                    "tipo_documentoid"=> 1,
                    "generoid"=> 1,
                    "email"=>"algo@correo.com.ar",
                    "cuil"=>"20367655678",
                    "estudios"=> [[
                        "nivel_educativoid"=>4,
                        "titulo"=>"tecnico en desarrollo web",
                        "completo"=>1,
                        "en_curso"=>0,
                        "anio"=>"2014"
                    ]],
                    "lugar"=> [
                        "barrio"=>"Don bosco",
                        "calle"=>"Mitre",
                        "altura"=>"327",
                        "piso"=>"A",
                        "depto"=>"",
                        "escalera"=>"",
                        "localidadid"=>1,
                        "latitud"=>"-123123",
                        "longitud"=>"321123"
                    ]

                ]
            ]            
        ];
        
        $I->sendPUT('/api/destinatarios/1', $param);
        
        $I->seeResponseContainsJson([
            'message' => 'Se modifica un Destinatario',
            'success' => true
        ]);
        
        $I->seeResponseCodeIs(200);
        
       
        //chequeamos lo guardado, no se testea la fecha de ingreso, ya que hay diferencia de segundos en chequear y nunca coincide
        $model = Destinatario::findOne(['legajo'=>'usb123/1']);
        $id = $model->id;
        $I->sendGET("/api/destinatarios/$id");
        $I->seeResponseContainsJson([
            'id' => $id,
            'legajo' => 'usb123/1',
            'calificacion' => 7,
            'origen' => 'un origen test modificado',
            'observacion' => 'Una observacion',
            'deseo_lugar_entrenamiento' => 'Donde desea realizar el entrenamiento',
            'deseo_actividad' => 'La actividad que desea realizar',
            'fecha_presentacion' => '2000-12-12',
            'personaid' => 100, //un persona hecha con mock
            'banco_cbu' => '54321987654',
            'banco_nombre' => 'Patagonia',
            'banco_alias' => 'CAMION-RODILLO-RUEDA',
            'experiencia_laboral' => 0,
            'conocimientos_basicos' => null,
        ]);
        $I->seeResponseCodeIs(200);        
        
    }
    
    /**
    * @param ApiTester $I
    */
    public function viewDestinatario(ApiTester $I)
    {
        $I->haveFixtures([
            'destinatarios' => app\tests\fixtures\DestinatarioFixture::className(),
        ]);
        $I->wantTo('Se visualiza un destinatario');
        
        $I->sendGET('/api/destinatarios/1');
        
        $I->seeResponseContainsJson(
                
            [
                "id"=> 1,
                "legajo"=> "usb123/6",
                "calificacion"=> 1,
                "fecha_ingreso"=> "2018-09-12",
                "origen"=> "un origen fixture",
                "observacion"=> "1",
                "deseo_lugar_entrenamiento"=> "1",
                "deseo_actividad"=> "1",
                "fecha_presentacion"=> "2010-10-10",
                "personaid"=> 2,
                "banco_cbu"=> "1",
                "banco_nombre"=> "1",
                "banco_alias"=> "1",
                "experiencia_laboral"=> 1,
                "conocimientos_basicos"=> null,
                "persona"=> [
                    'id' => 2
                ],
            ]
        );
        
        $I->seeResponseCodeIs(200);    
        
    }
    
    /**
    * @param ApiTester $I
    */
    public function listaDestinatario(ApiTester $I)
    {
        $I->haveFixtures([
            'destinatarios' => app\tests\fixtures\DestinatarioFixture::className(),
        ]);
        $I->wantTo('Se lista destinatarios');
        
        $I->sendGET('/api/destinatarios');
        
        $I->seeResponseContainsJson(
                
            [
            "total_filtrado"=> 4,
            "success"=> true,
            "resultado"=> [
                [
                    "id"=> 1,
                    "legajo"=> "usb123/6",
                    "calificacion"=> 1,
                    "fecha_ingreso"=> "2018-09-12",
                    "origen"=> "un origen fixture",
                    "observacion"=> "1",
                    "deseo_lugar_entrenamiento"=> "1",
                    "deseo_actividad"=> "1",
                    "fecha_presentacion"=> "2010-10-10",
                    "personaid"=> 2,
                    "banco_cbu"=> "1",
                    "banco_nombre"=> "1",
                    "banco_alias"=> "1",
                    "experiencia_laboral"=> 1,
                    "conocimientos_basicos"=> null
                ],
                [
                    "id"=> 2,
                    "legajo"=> "usb123/7",
                    "calificacion"=> 1,
                    "fecha_ingreso"=> "2017-11-12",
                    "origen"=> "un origen fixture",
                    "observacion"=> "1",
                    "deseo_lugar_entrenamiento"=> "1",
                    "deseo_actividad"=> "1",
                    "fecha_presentacion"=> "2010-10-10",
                    "personaid"=> 3,
                    "banco_cbu"=> "1",
                    "banco_nombre"=> "1",
                    "banco_alias"=> "1",
                    "experiencia_laboral"=> 1,
                    "conocimientos_basicos"=> null
                ],
                [
                    "id"=> 3,
                    "legajo"=> "usb123/8",
                    "calificacion"=> 1,
                    "fecha_ingreso"=> "2017-10-12",
                    "origen"=> "un origen fixture",
                    "observacion"=> "1",
                    "deseo_lugar_entrenamiento"=> "1",
                    "deseo_actividad"=> "1",
                    "fecha_presentacion"=> "2010-10-10",
                    "personaid"=> 4,
                    "banco_cbu"=> "1",
                    "banco_nombre"=> "1",
                    "banco_alias"=> "1",
                    "experiencia_laboral"=> 1,
                    "conocimientos_basicos"=> null
                ],
                [
                    "id"=> 4,
                    "legajo"=> "usb123/9",
                    "calificacion"=> 1,
                    "fecha_ingreso"=> "2019-01-12",
                    "origen"=> "un origen fixture",
                    "observacion"=> "1",
                    "deseo_lugar_entrenamiento"=> "1",
                    "deseo_actividad"=> "1",
                    "fecha_presentacion"=> "2010-10-10",
                    "personaid"=> 5,
                    "banco_cbu"=> "1",
                    "banco_nombre"=> "1",
                    "banco_alias"=> "1",
                    "experiencia_laboral"=> 1,
                    "conocimientos_basicos"=> null
                ]
            ]
        ]
        );
        
        $I->seeResponseCodeIs(200);    
        
    }
}
