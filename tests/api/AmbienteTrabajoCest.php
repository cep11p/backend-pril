<?php

use Helper\Api;
use app\models\AmbienteTrabajo;
class AmbienteTrabajoCest
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
            'ambientes_trasbajos' => \app\tests\fixtures\AmbienteTrabajoFixture::className(),
        ];
    }

    public function _after(ApiTester $I)
    {
        $I->unloadFixtures([new  app\tests\fixtures\AmbienteTrabajoFixture]);
    }

    // tests
    public function agregarUnAmbienteTrabajoConCamposVacios(ApiTester $I)
    {
        $I->wantTo('Agregar Un Ambiente de trabajo con los campos vacios');
        $param=[];
        
        $I->sendPOST('/api/ambiente-trabajos', $param);
        
        $I->seeResponseContainsJson([
            
            'message' => 
                        '{"lugar":{'
                            . '"calle":["Calle no puede estar vac\u00edo."],'
                            . '"altura":["Altura no puede estar vac\u00edo."],'
                            . '"localidadid":["Localidadid no puede estar vac\u00edo."]},'
                        . '"persona":{'
                            . '"nombre":["Nombre no puede estar vac\u00edo."],'
                            . '"apellido":["Apellido no puede estar vac\u00edo."],'
                            . '"nro_documento":["Nro Documento no puede estar vac\u00edo."],'
                            . '"fecha_nacimiento":["Fecha Nacimiento no puede estar vac\u00edo."],'
                            . '"estado_civilid":["Estado Civilid no puede estar vac\u00edo."],'
                            . '"email":["Email no puede estar vac\u00edo."],'
                            . '"sexoid":["Sexoid no puede estar vac\u00edo."],'
                            . '"generoid":["Generoid no puede estar vac\u00edo."]},'
                        . '"ambiente_trabajo":{'
                            . '"nombre":["Nombre no puede estar vac\u00edo."],'
                            . '"legajo":["Legajo no puede estar vac\u00edo."],'
                            . '"tipo_ambiente_trabajoid":["Tipo Ambiente Trabajoid no puede estar vac\u00edo."]}}'


            
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
                "nombre"=> "Panaderia San Fernando",
                "calificacion"=> 7,
                "legajo"=> "asb123/7",
                "observacion"=>"es una empresa que realiza actividades de panaderia y pasteleria",
                "cuit"=>"20123456789",
                "actividad"=> "Vende facturas, tortas y variedades de panes",
                "tipo_ambiente_trabajoid"=> 1,
                "persona"=>[
                    "nombre"=> "Diego",
                    "apellido"=> "Matinez",
                    "nro_documento"=> "27890098",
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
                    "cuil"=>"20367655678"

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
            "nombre"=> "Panaderia San Fernando",
            "calificacion"=> 7,
            "legajo"=> "asb123/7",
            "observacion"=>"es una empresa que realiza actividades de panaderia y pasteleria",
            "cuit"=>"20123456789",
            "actividad"=> "Vende facturas, tortas y variedades de panes",
            "tipo_ambiente_trabajoid"=> 1,
            "lugar"=>[
                "calle"=>"Mata Negra",
                "altura"=>"123",
                "localidadid"=>0
            ],
            "persona"=>[
                "nombre"=> "Diego",
                "apellido"=> "Matinez",
                "nro_documento"=> "27890098",
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
                "cuil"=>"20367655678"
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
            "nombre"=> "Panaderia San Fernando",
            "calificacion"=> 7,
            "legajo"=> "asb123/7",
            "observacion"=>"es una empresa que realiza actividades de panaderia y pasteleria",
            "cuit"=>"20123456789",
            "actividad"=> "Vende facturas, tortas y variedades de panes",
            "tipo_ambiente_trabajoid"=> 1,
            "lugarid"=>0,
            "lugar"=>[
                "calle"=>"Mata Negra",
                "altura"=>"123",
                "localidadid"=>1
            ],
            "persona"=>[
                "nombre"=> "Diego",
                "apellido"=> "Matinez",
                "nro_documento"=> "27890098",
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
                "cuil"=>"20367655678"

            ]
        ];
        
        $I->sendPOST('/api/ambiente-trabajos', $param);
        
        $I->seeResponseContainsJson([
            'message' => '{"ambiente_trabajo":{"lugarid":["No se pudo registrar el Lugar correctamente en el Sistema Lugar."]}}',
        ]);
        
        $I->seeResponseCodeIs(500);
    
    }
    
    public function agregarUnAmbienteTrabajo(ApiTester $I)
    {
        $I->wantTo('Agregar Un Ambiente');
        $param=[
            "nombre"=> "Panaderia San Fernando",
            "calificacion"=> 7,
            "legajo"=> "asb123/7",
            "observacion"=>"es una empresa que realiza actividades de panaderia y pasteleria",
            "cuit"=>"20123456789",
            "actividad"=> "Vende facturas, tortas y variedades de panes",
            "tipo_ambiente_trabajoid"=> 1,
            "lugar"=>[
                "calle"=>"Mata Negra",
                "altura"=>"123",
                "localidadid"=>1
            ],
            "persona"=>[
                "nombre"=> "Diego",
                "apellido"=> "Matinez",
                "nro_documento"=> "27890098",
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
                "cuil"=>"20367655678"

            ]
        ];
        
        $I->sendPOST('/api/ambiente-trabajos', $param);
        $I->seeResponseContainsJson([
            'message' => 'Se guarda un Ambiente de Trabajo',
            'success' => true
        ]);
        
        $I->seeResponseCodeIs(200);
        
        //chequeamos lo guardado
        $model = AmbienteTrabajo::findOne(['legajo'=>'asb123/7']);
        $id = $model->id;
        $I->sendGET("/api/ambiente-trabajos/$id");
        $I->seeResponseContainsJson([
            'id' => $id,
            "nombre"=> "Panaderia San Fernando",
            "calificacion"=> 7,
            "legajo"=> "asb123/7",
            "observacion"=>"es una empresa que realiza actividades de panaderia y pasteleria",
            "cuit"=>"20123456789",
            "actividad"=> "Vende facturas, tortas y variedades de panes",
            "tipo_ambiente_trabajoid"=> 1,
        ]);
        $I->seeResponseCodeIs(200);
    
    }
    
}
