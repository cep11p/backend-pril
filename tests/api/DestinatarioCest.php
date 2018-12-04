<?php

use Helper\Api;
use app\models\Destinatario;
date_default_timezone_set ('America/Argentina/Buenos_Aires');

class DestinatarioCest
{
    
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
    
    public function _after(ApiTester $I)
    { 
//        $I->unloadFixtures([new  app\tests\fixtures\DestinatarioFixture]);
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
                "oficioid"=>1,
		"profesionid"=>2,
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
            'message' => '{'
            . '"persona":{'
                . '"nombre":["Nombre no puede estar vac\u00edo."],'
                . '"apellido":["Apellido no puede estar vac\u00edo."],'
                . '"nro_documento":["Nro Documento no puede estar vac\u00edo."],'
                . '"fecha_nacimiento":["Fecha Nacimiento no puede estar vac\u00edo."],'
                . '"estado_civilid":["Estado Civilid no puede estar vac\u00edo."],'
                . '"email":["Email no puede estar vac\u00edo."],'
                . '"sexoid":["Sexoid no puede estar vac\u00edo."],'
                . '"generoid":["Generoid no puede estar vac\u00edo."]},'
                . '"lugar":{"calle":["Calle no puede estar vac\u00edo."],'
                . '"altura":["Altura no puede estar vac\u00edo."],'
                . '"localidadid":["Localidadid no puede estar vac\u00edo."]}'
            . '}'
        ]);
        
        $I->seeResponseCodeIs(400);
        
        
    }
    
    public function crearDestinatarioSinDatos(ApiTester $I)
    {
        $I->wantTo('Se registra un destinatario sin Datos');
        $param=[];
        
        $I->sendPOST('/api/destinatarios', $param);
        
        $I->seeResponseContainsJson([
            'message' => '{'
            . '"destinatario":{'
                . '"legajo":["Legajo no puede estar vac\u00edo."],'
                . '"fecha_ingreso":["Fecha Ingreso no puede estar vac\u00edo."],'
                . '"fecha_presentacion":["Fecha Presentacion no puede estar vac\u00edo."]},'
            . '"persona":{'
                . '"nombre":["Nombre no puede estar vac\u00edo."],'
                . '"apellido":["Apellido no puede estar vac\u00edo."],'
                . '"nro_documento":["Nro Documento no puede estar vac\u00edo."],'
                . '"fecha_nacimiento":["Fecha Nacimiento no puede estar vac\u00edo."],'
                . '"estado_civilid":["Estado Civilid no puede estar vac\u00edo."],'
                . '"email":["Email no puede estar vac\u00edo."],'
                . '"sexoid":["Sexoid no puede estar vac\u00edo."],'
                . '"generoid":["Generoid no puede estar vac\u00edo."]},'
                . '"lugar":{"calle":["Calle no puede estar vac\u00edo."],'
                . '"altura":["Altura no puede estar vac\u00edo."],'
                . '"localidadid":["Localidadid no puede estar vac\u00edo."]'
                . '}'
            . '}'
        ]);
        
        $I->seeResponseCodeIs(400);
        
        
    }
    
    public function crearDestinatarioConLegajoExistente(ApiTester $I)
    {
        $I->wantTo('Se registra un destinatario con legajo existente');
        $param=[
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/6",
                "oficioid"=>1,
		"profesionid"=>2,
		"fecha_presentacion"=>"2000-12-12",
		"origen"=> "un origen test",
		"deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
		"deseo_actividad"=> "La actividad que desea realizar",
		"experiencia_laboral"=> 1,
		"banco_cbu"=> "54321987654",
		"banco_nombre"=> "Patagonia",
		"banco_alias"=> "CAMION-RODILLO-RUEDA",
		"observacion"=> "Una observacion"
            ],
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
        $param=[
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/1",
                "oficioid"=>1,
		"profesionid"=>2,
		"fecha_presentacion"=>"2000-12-12",
		"origen"=> "un origen test",
		"deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
		"deseo_actividad"=> "La actividad que desea realizar",
		"experiencia_laboral"=> 1,
		"banco_cbu"=> "54321987654",
		"banco_nombre"=> "Patagonia",
		"banco_alias"=> "CAMION-RODILLO-RUEDA",
		"observacion"=> "Una observacion"
            ],
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
            'oficioid' => 1,
            'legajo' => 'usb123/1',
            'calificacion' => 7,
            'profesionid' => 2,
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
            'profesion' => 'Académico/a',
            'oficio' => 'Albañil',
            "persona"=>[
                'id' => 100,
                'nombre' => 'Pilar',
                'apellido' => 'Test',
                'nro_documento' => '29890123',
                'fecha_nacimiento' => '1980-12-12',
                'apodo' => 'rominochi',
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
    
    public function crearDestinatarioConPersonaExistente(ApiTester $I)
    {
        $I->wantTo('Se agrega un Destinatario con persona existente');
        $param=[
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/1",
                "oficioid"=>1,
		"profesionid"=>2,
		"fecha_presentacion"=>"2000-12-12",
		"origen"=> "un origen test",
		"deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
		"deseo_actividad"=> "La actividad que desea realizar",
		"experiencia_laboral"=> 1,
		"banco_cbu"=> "54321987654",
		"banco_nombre"=> "Patagonia",
		"banco_alias"=> "CAMION-RODILLO-RUEDA",
		"observacion"=> "Una observacion"
            ],
            "persona"=>[
                "id"=>2,
                "nombre"=> "Pilar",
                "apellido"=> "Test",
                "nro_documento"=> "29890124",
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
            'oficioid' => 1,
            'legajo' => 'usb123/1',
            'calificacion' => 7,
            'profesionid' => 2,
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
            'profesion' => 'Académico/a',
            'oficio' => 'Albañil',
            "persona"=>[
                'id' => 100,
                'nombre' => 'Pilar',
                'apellido' => 'Test',
                'nro_documento' => '29890123',
                'fecha_nacimiento' => '1980-12-12',
                'apodo' => 'rominochi',
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
    
    public function modificarDestinatarioConPersonaMock(ApiTester $I)
    {
        $I->wantTo('Se modifica un Destinatario con persona mock');
        $param=[
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/1",
                "oficioid"=>1,
		"profesionid"=>2,
		"fecha_presentacion"=>"2000-12-12",
		"origen"=> "un origen test modificado",
		"deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
		"deseo_actividad"=> "La actividad que desea realizar",
		"experiencia_laboral"=> 1,
		"banco_cbu"=> "54321987654",
		"banco_nombre"=> "Patagonia",
		"banco_alias"=> "CAMION-RODILLO-RUEDA",
		"observacion"=> "Una observacion"
            ],
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
            'oficioid' => 1,
            'legajo' => 'usb123/1',
            'calificacion' => 7,
            'profesionid' => 2,
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
            'profesion' => 'Académico/a',
            'oficio' => 'Albañil',
        ]);
        $I->seeResponseCodeIs(200);        
        
    }
}
