<?php

use Helper\Api;
use app\models\AmbienteTrabajo;
class AreaEntrenamientoCest
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
            'area_entrenamiento'=> \app\tests\fixtures\AreaEntrenamientoFixture::className(),
//            'destinatario'=> app\tests\fixtures\DestinatarioFixture::className(),
//            'area'=> \app\tests\fixtures\AreaEntrenamientoFixture::className(),
//            'ambientes_trasbajos' => \app\tests\fixtures\AmbienteTrabajoFixture::className(),
        ];
    }


    // tests
    public function agregarUnAreaEntrenamientoConCamposVacios(ApiTester $I)
    {
        $I->wantTo('Agregar Un Area de entranamiento con los campos vacios');
        $param=[];
        
        $I->sendPOST('/api/area-entrenamientos', $param);
        
        $I->seeResponseContainsJson([
                'message' => '{"tarea":["Tarea no puede estar vac\u00edo."],"planid":["Planid no puede estar vac\u00edo."],"destinatarioid":["Destinatarioid no puede estar vac\u00edo."],"ofertaid":["Ofertaid no puede estar vac\u00edo."]}'
            ]);
        
        $I->seeResponseCodeIs(500);
        
    }
    
        
    public function agregarUnAreaEntrenamiento(ApiTester $I)
    {
        $I->wantTo('Agregar Un Area de entranamiento');
        $param=[
            "tarea"=>"una tarea",
            "planid"=>1,
            "ofertaid"=>5,
            "destinatarioid"=>2,
            "fecha_inicial"=>"2018-12-12",
            "observacion"=>"una observacion",
            "jornada"=>"una jornada"
        ];
        
        $I->sendPOST('/api/area-entrenamientos', $param);
        
        $I->seeResponseContainsJson([
                'message' => 'Se registra un Area de entrenamiento'
            ]);
        
        $I->seeResponseCodeIs(200);
        
    }
    
    public function agregarUnAreaEntrenamientoConOfertaEnUso(ApiTester $I)
    {
        $I->wantTo('Agregar Un Area de entranamiento con oferta en uso');
        $param=[
            "tarea"=>"una tarea",
            "planid"=>1,
            "ofertaid"=>4,
            "destinatarioid"=>2,
            "fecha_inicial"=>"2018-12-12",
            "observacion"=>"una observacion",
            "jornada"=>"una jornada"
        ];
        
        $I->sendPOST('/api/area-entrenamientos', $param);
        
        $I->seeResponseContainsJson([
                'message' => '{"ofertaid":["Ofertaid \"4\" ya ha sido utilizado."]}'
            ]);
        
        $I->seeResponseCodeIs(500);
        
    }
    
    public function agregarUnAreaEntrenamientoConDestinatarioEnAreaVigente(ApiTester $I)
    {
        $I->haveFixtures([
            'area_entrenamiento'=> \app\tests\fixtures\AreaEntrenamientoFixture::className(),
        ]);   
        
        $I->wantTo('Agregar Un Area de entranamiento con destinatario en area vigente');
        $param=[
            "tarea"=>"una tarea",
            "planid"=>1,
            "ofertaid"=>5,
            "destinatarioid"=>4,
            "fecha_inicial"=>"2018-12-12",
            "observacion"=>"una observacion",
            "jornada"=>"una jornada"
        ];
        
        $I->sendPOST('/api/area-entrenamientos', $param);
        
        $I->seeResponseContainsJson([
                'message' => '{"destinatarioid":["El destinatario se encuentra en una area de entrenamiento todav\u00eda vigente."]}'
            ]);
        
        $I->seeResponseCodeIs(500);
        
    }
    
    public function modificarUnAreaEntrenamiento(ApiTester $I)
    {
        $I->wantTo('Se modifica un Area de entranamiento');
        $param=[
            "tarea"=>"una tarea modificada",
            "planid"=>1,
            "ofertaid"=>3,
            "destinatarioid"=>2,
            "observacion"=>"una observacion modificada",
            "jornada"=>"una jornada modificada"
        ];
        
        $I->sendPUT('/api/area-entrenamientos/2',$param);
        
        $I->seeResponseContainsJson([
                'message' => 'Se modifica el Area de entrenamiento'
            ]);
        
        $I->seeResponseCodeIs(200);
        
        $I->sendGET('/api/area-entrenamientos/2');
        
        $I->seeResponseContainsJson([            
            "id"=> 2,
            "tarea"=> "una tarea modificada",
            "planid"=> 1,
            "destinatarioid"=> 2,
            "fecha_inicial"=> "2017-10-12 00:00:00",
            "fecha_final"=> null,
            "descripcion_baja"=> null,
            "ofertaid"=> 3,
            "jornada"=> "una jornada modificada",
            "observacion"=> "una observacion modificada",
            "plan_nombre"=> "Plan A",
            "plan_monto"=> "2000",
            "plan_hora_semanal"=> "10hs",
            "destintario"=> [
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
                "conocimientos_basicos"=> null,
                "persona"=> [
                    "id"=> 3,
                    "nombre"=> "Pilar",
                    "apellido"=> "Test",
                    "nro_documento"=> "29890123",
                    "fecha_nacimiento"=> "1980-12-12",
                    "apodo"=> "rominochi",
                    "telefono"=> "2920430690",
                    "celular"=> "2920412127",
                    "situacion_laboralid"=> 1,
                    "estado_civilid"=> 1,
                    "sexoid"=> 2,
                    "tipo_documentoid"=> 1,
                    "generoid"=> 1,
                    "email"=> "algo@correo.com.ar",
                    "cuil"=> "20367655678",
                    "estudios"=> [],
                    "lugar"=> [
                        "id"=> 3,
                        "barrio"=> "Castello",
                        "calle"=> "tres arroyos",
                        "altura"=> "765",
                        "piso"=> "",
                        "depto"=> "",
                        "escalera"=> "",
                        "localidadid"=> 1,
                        "localidad"=> "nombreDeLocalidad"
                    ]
                ]
            ],
            "oferta"=> [
                "id"=> 3,
                "ambiente_trabajoid"=> 1,
                'nombre_sucursal' => 'Sucursal Nº 2',
                'puesto' => 'Limipieza',
                "area"=> "",
                'fecha_inicial' => '2018-09-13 09:34:45',
                "fecha_final"=> null,
                'demanda_laboral' => 'falta mantenimiento en la sucursal',
                'objetivo' => 'conseguir personal especificamente para limpieza',
                "lugarid"=> 2,
                "lugar"=> [
                    "id"=> 2,
                    "nombre"=> "",
                    'barrio' => 'Ina Lauquen',
                    'calle' => 'Saavedra',
                    'altura' => '321',
                    'piso' => '',
                    "depto"=> "",
                    "escalera"=> "",
                    "localidadid"=> 1,
                    'latitud' => '-123321',
                    'longitud' => '321321',
                ],
                    'telefono' => '',
                    'estado' => 'vigente'
            ],
            "ambiente_trabajo"=> [
                "nombre"=> "Panaderia San Fernando",
                "cuit"=> "20123456789",
                "legajo"=> "asb123/8",
                "persona"=> [
                    "nombre"=> "Pilar",
                    "apellido"=> "Test",
                    "nro_documento"=> "29890123",
                    "telefono"=> "2920430690",
                    "celular"=> "2920412127",
                    "email"=> "algo@correo.com.ar"
                ]
            ]            
        ]);
        
        $I->seeResponseCodeIs(200);
        
    }
    
    public function vistaAreaEntrenamiento(ApiTester $I)
    {
        $I->wantTo('se visualiza un Area de entranamiento');
        
        $I->sendGET('/api/area-entrenamientos/4');
        
        $I->seeResponseContainsJson([            
            "id"=> 4,
            "tarea"=> "una tarea fixture",
            "planid"=> 1,
            "destinatarioid"=> 4,
            'fecha_inicial' => '2017-10-13 00:00:00',
            'fecha_final' => '2019-11-19 00:00:00',
            "descripcion_baja"=> null,
            "ofertaid"=> 1,
            "jornada"=> "una jornada",
            "observacion"=> "una observacion",
            "plan_nombre"=> "Plan A",
            "plan_monto"=> "2000",
            "plan_hora_semanal"=> "10hs",
            "destintario"=> [
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
                "conocimientos_basicos"=> null,
                "persona"=> [
                    "id"=> 5,
                    "nombre"=> "Pilar",
                    "apellido"=> "Test",
                    "nro_documento"=> "29890123",
                    "fecha_nacimiento"=> "1980-12-12",
                    "apodo"=> "rominochi",
                    "telefono"=> "2920430690",
                    "celular"=> "2920412127",
                    "situacion_laboralid"=> 1,
                    "estado_civilid"=> 1,
                    "sexoid"=> 2,
                    "tipo_documentoid"=> 1,
                    "generoid"=> 1,
                    "email"=> "algo@correo.com.ar",
                    "cuil"=> "20367655678",
                    "estudios"=> [],
                    "lugar"=> [
                        "id"=> 5,
                        "barrio"=> "San roque",
                        "calle"=> "Italia",
                        "altura"=> "300",
                        "piso"=> "",
                        "depto"=> "",
                        "escalera"=> "",
                        "localidadid"=> 1,
                        "localidad"=> "nombreDeLocalidad"
                    ]
                ]
            ],
            "oferta"=> [
                "id"=> 1,
                "ambiente_trabajoid"=> 1,
                "nombre_sucursal"=> "Sucursal Nº 1",
                "puesto"=> "cajera",
                "area"=> "",
                'fecha_inicial' => '2018-10-13 10:34:45',
                'fecha_final' => null,
                "demanda_laboral"=> "falta una cajera",
                "objetivo"=> "conseguir personal especificamente para la caja",
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
                ]
            ],
            "ambiente_trabajo"=> [
                "nombre"=> "Panaderia San Fernando",
                "cuit"=> "20123456789",
                "legajo"=> "asb123/8",
                "persona"=> [
                    "nombre"=> "Pilar",
                    "apellido"=> "Test",
                    "nro_documento"=> "29890123",
                    "telefono"=> "2920430690",
                    "celular"=> "2920412127",
                    "email"=> "algo@correo.com.ar"
                ]
            ]           
        ]);
        
        $I->seeResponseCodeIs(200);
        
    }
    
    public function listarAreaEntrenamiento(ApiTester $I)
    {
        $I->wantTo('listar Area de entrenamiento');
        
        $I->haveFixtures(["area_entrenamientos" => \app\tests\fixtures\AreaEntrenamientoFixture::className()]);
        
        $I->sendGET('/api/area-entrenamientos');
        
        $I->seeResponseContainsJson([
            "total_filtrado"=> 4,
            "success"=> true,
            "resultado"=> [
                [
                    "id"=> 1,
                    "destinatarioid"=> 1,
                    "ofertaid"=> 4,
                    "fecha_inicial"=> "2018-12-12 00:00:00",
                    'fecha_final' => '2019-06-12 00:00:00',
                    "tarea"=> "una tarea fixture",
                    "plan_nombre"=> "Plan A",
                    "plan_monto"=> "2000",
                    "plan_hora_semanal"=> "10hs",
                    "estado"=> "finalizada",
                    "oferta"=> [
                        "id"=> 4,
                        "ambiente_trabajoid"=> 2,
                        "ambiente_trabajo"=> "Panaderia Boomble",
                        "nombre_sucursal"=> "Sucursal Nº 1"
                    ]
                ],
                [
                    "id"=> 2,
                    "destinatarioid"=> 2,
                    "ofertaid"=> 3,
                    "fecha_inicial"=> "2017-10-12 00:00:00",
                    "fecha_final"=> null,
                    "tarea"=> "una tarea fixture",
                    "plan_nombre"=> "Plan A",
                    "plan_monto"=> "2000",
                    "plan_hora_semanal"=> "10hs",
                    "estado"=> "vigente",
                    "oferta"=> [
                        "id"=> 3,
                        "ambiente_trabajoid"=> 1,
                        "ambiente_trabajo"=> "Panaderia San Fernando",
                        "nombre_sucursal"=> "Sucursal Nº 2"
                    ]
                ],
                [
                    "id"=> 3,
                    "destinatarioid"=> 3,
                    "ofertaid"=> 2,
                    "fecha_inicial"=> "2017-10-12 00:00:00",
                    "fecha_final"=> null,
                    "tarea"=> "una tarea fixture",
                    "plan_nombre"=> "Plan A",
                    "plan_monto"=> "2000",
                    "plan_hora_semanal"=> "10hs",
                    "estado"=> "vigente",
                    "oferta"=> [
                        "id"=> 2,
                        "ambiente_trabajoid"=> 1,
                        "ambiente_trabajo"=> "Panaderia San Fernando",
                        "nombre_sucursal"=> "Sucursal Nº 2"
                    ]
                ],
                [
                    "id"=> 4,
                    "destinatarioid"=> 4,
                    "ofertaid"=> 1,
                    "fecha_inicial"=> "2017-10-13 00:00:00",
                    'fecha_final' => '2019-11-19 00:00:00',
                    "tarea"=> "una tarea fixture",
                    "plan_nombre"=> "Plan A",
                    "plan_monto"=> "2000",
                    "plan_hora_semanal"=> "10hs",
                    "estado"=> "vigente",
                    "oferta"=> [
                        "id"=> 1,
                        "ambiente_trabajoid"=> 1,
                        "ambiente_trabajo"=> "Panaderia San Fernando",
                        "nombre_sucursal"=> "Sucursal Nº 1"
                    ]
                ],
            ]
        ]);
        
        $I->seeResponseCodeIs(200);
        
    }
    
    
}
