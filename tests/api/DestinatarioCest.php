<?php

use Helper\Api;
class DestinatarioCest
{
    protected $api;
    
    public function _before(ApiTester $I,Api $api)
    {
        $I->wantTo('Login');
        $token = $api->generarToken();
        $I->amBearerAuthenticated($token);
    }
    
//    public function _fixtures()
//    {
//        return [
//            'destinatario' => DestinatarioFixture::className(),
//        ];
//    }

    // tests
    public function crearDestinatarioConPersonaNoExistente(ApiTester $I)
    {
        $I->wantTo('Agregar Destinataro Con Persona No existente');
        $param=[
            "destinatario"=>[
		"calificacion"=> 7,
		"legajo"=> "usb123/7",
                "oficioid"=>1,
		"profesionid"=>2,
		"fecha_presentacion"=>"2000-12-12",
		"fecha_ingreso"=> "2000-12-12",
		"origen"=> "un origen",
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
                "apellido"=> "testApi",
                "nro_documento"=> "29890098",
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
                "estudios"=> [
                    [
                    "nivel_educativoid"=>4,
                    "titulo"=>"Maestra",
                    "completo"=>1,
                    "en_curso"=>0,
                    "fecha"=>"2014-12-20"
                    ]
                ],
                "hogar"=> [
                    "barrio"=>"Don bosco",
                    "calle"=>"Mitre",
                    "altura"=>"327",
                    "piso"=>"",
                    "depto"=>"",
                    "localidadid"=>1,
                    "tiene_gas"=>0,
                    "tiene_luz"=>0,
                    "tiene_agua"=>0,
                    "condicion_ocupacionid"=>1,
                    "obtencion_aguaid"=> 1,
                    "tipo_desagueid"=> 1,
                    "cocina_combustibleid"=> 1,
                    "tipo_viviendaid"=> 1,
                    "habitacion_dormir"=> 2,
                    "banioid"=> 1
                ]
            ],
        ];
        
        $I->sendPOST('/api/destinatarios', $param);
        
        $I->seeResponseContainsJson([
            'message' => 'Se guarda un Destinatario',
            'success' => true
        ]);
        
        $I->seeResponseCodeIs(500); 
    }
}
