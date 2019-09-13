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
        $I->wantTo('Agregar Un Area de entranamiento con los campos vacios');
        $param=[
            "tarea"=>"una tarea",
            "planid"=>1,
            "ofertaid"=>1,
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
    
    public function listarAreaEntrenamiento(ApiTester $I)
    {
        $I->wantTo('listar Area de entrenamiento');
        
        $I->sendGET('/api/area-entrenamientos');
        
        $I->seeResponseContainsJson([
            "total_filtrado"=> 5,
            "success"=> true,
            "resultado"=> [
                [
                    "id"=> 1,
                    "destinatarioid"=> 1,
                    "ofertaid"=> 4,
                    "fecha_inicial"=> "2018-12-12 00:00:00",
                    "fecha_final"=> null,
                    "tarea"=> "una tarea fixture",
                    "plan_nombre"=> "Plan A",
                    "plan_monto"=> "2000",
                    "plan_hora_semanal"=> "10hs",
                    "estado"=> "Vigente (estatico)",
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
                    "estado"=> "Vigente (estatico)",
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
                    "estado"=> "Vigente (estatico)",
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
                    "fecha_inicial"=> "2017-10-12 00:00:00",
                    "fecha_final"=> null,
                    "tarea"=> "una tarea fixture",
                    "plan_nombre"=> "Plan A",
                    "plan_monto"=> "2000",
                    "plan_hora_semanal"=> "10hs",
                    "estado"=> "Vigente (estatico)",
                    "oferta"=> [
                        "id"=> 1,
                        "ambiente_trabajoid"=> 1,
                        "ambiente_trabajo"=> "Panaderia San Fernando",
                        "nombre_sucursal"=> "Sucursal Nº 1"
                    ]
                ],
                [
                    "id"=> 5,
                    "destinatarioid"=> 2,
                    "ofertaid"=> 1,
                    "fecha_inicial"=> "2018-12-12 03:00:00",
                    "fecha_final"=> null,
                    "tarea"=> "una tarea",
                    "plan_nombre"=> "Plan A",
                    "plan_monto"=> "2000",
                    "plan_hora_semanal"=> "10hs",
                    "estado"=> "Vigente (estatico)",
                    "oferta"=> [
                        "id"=> 1,
                        "ambiente_trabajoid"=> 1,
                        "ambiente_trabajo"=> "Panaderia San Fernando",
                        "nombre_sucursal"=> "Sucursal Nº 1"
                    ]
                ]
            ]
        ]);
        
        $I->seeResponseCodeIs(200);
        
    }
    
    
}
