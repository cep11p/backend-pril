<?php

use Helper\Api;
class AmbienteTrabajoCest
{
    public function _before(ApiTester $I,Api $api)
    {
        $I->wantTo('Login');
        $token = $api->generarToken();
        $I->amBearerAuthenticated($token);
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function agregarUnAmbienteTrabajoConCamposVacios(ApiTester $I)
    {
        $I->wantTo('Agregar Un Ambiente de trabajo con los campos vacios');
        $param=[];
        
        $I->sendPOST('/api/ambiente-trabajos', $param);
        
        $I->seeResponseContainsJson([
            'message' => '{"lugar":{"calle":["Calle no puede estar vac\u00edo."],"altura":["Altura no puede estar vac\u00edo."],"localidadid":["Localidadid no puede estar vac\u00edo."]},"ambiente_trabajo":{"nombre":["Nombre no puede estar vac\u00edo."],"tipo_ambiente_trabajoid":["Tipo Ambiente Trabajoid no puede estar vac\u00edo."]}}',
        ]);
        
        $I->seeResponseCodeIs(500);
        
    }
    /**
     * Si los campos de lugar estan vacios se debe notificar
     * @param ApiTester $I
     */
    public function agregarUnAmbienteTrabajoConCamposDeLugarVacio(ApiTester $I)
    {
        $I->wantTo('Agregar Un Ambiente de trabajo con los Campos De Lugar Vacio');
        $param=[
            "ambiente_trabajo"=>[
                "nombre"=> "Panaderia San Fernando",
                "calificacion"=> 7,
                "legajo"=> "asb123/7",
                "observacion"=>"es una empresa que realiza actividades de panaderia y pasteleria",
                "cuit"=>"20123456789",
                "actividad"=> "Vende facturas, tortas y variedades de panes",
                "tipo_ambiente_trabajoid"=> 1
            ]
        ];
        
        $I->sendPOST('/api/ambiente-trabajos', $param);
        
        $I->seeResponseContainsJson([
            'message' => '{"lugar":{"calle":["Calle no puede estar vac\u00edo."],"altura":["Altura no puede estar vac\u00edo."],"localidadid":["Localidadid no puede estar vac\u00edo."]}}',
        ]);
        
        $I->seeResponseCodeIs(500);
        
    }
    /**
     * Si localidadid no existe, deberia ser notificado
     * @param ApiTester $I
     */
    public function agregarUnAmbienteTrabajoConLocalidadNoExistente(ApiTester $I)
    {
        $I->wantTo('Agregar Un Ambiente de trabajo con localidad no existente');
        $param=[
            "ambiente_trabajo"=>[
                "nombre"=> "Panaderia San Fernando",
                "calificacion"=> 7,
                "legajo"=> "asb123/7",
                "observacion"=>"es una empresa que realiza actividades de panaderia y pasteleria",
                "cuit"=>"20123456789",
                "actividad"=> "Vende facturas, tortas y variedades de panes",
                "tipo_ambiente_trabajoid"=> 1
            ],
            "lugar"=>[
                "calle"=>"Mata Negra",
                "altura"=>"123",
                "localidadid"=>0
            ]
        ];
        
        $I->sendPOST('/api/ambiente-trabajos', $param);
        
        $I->seeResponseContainsJson([
            'message' => '{"lugar":{"id":["La localidad con el id  no existe!"]}}',
        ]);
        
        $I->seeResponseCodeIs(500);
        
    }
    
    public function agregarUnAmbienteTrabajoConLugaridIncorrecto(ApiTester $I)
    {
        $I->wantTo('Agregar Un Ambiente de trabajo con lugarid incorrecto');
        $param=[
            "ambiente_trabajo"=>[
                "nombre"=> "Panaderia San Fernando",
                "calificacion"=> 7,
                "legajo"=> "asb123/7",
                "observacion"=>"es una empresa que realiza actividades de panaderia y pasteleria",
                "cuit"=>"20123456789",
                "actividad"=> "Vende facturas, tortas y variedades de panes",
                "tipo_ambiente_trabajoid"=> 1
            ],
            "lugar"=>[
                "id"=>0,
                "calle"=>"Mata Negra",
                "altura"=>"123",
                "localidadid"=>1
            ]
        ];
        
        $I->sendPOST('/api/ambiente-trabajos', $param);
        
        $I->seeResponseContainsJson([
            'message' => '{"ambiente_trabajo":{"lugarid":["No se pudo registrar el Lugar correctamente en el Sistema Lugar."]},"tab":"ambiente_trabajo"}',
        ]);
        
        $I->seeResponseCodeIs(500);
        
    }
}
