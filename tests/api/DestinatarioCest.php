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
        $I->unloadFixtures([new  app\tests\fixtures\DestinatarioFixture]);
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
}
