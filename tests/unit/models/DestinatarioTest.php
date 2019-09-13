<?php
use app\models\Destinatario;

class DestinatarioTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $this->tester->haveFixtures([
            \app\tests\fixtures\DestinatarioFixture::className()
        ]);
    }

    protected function _after()
    {
    }
    
    // tests
    public function testDisparaExcepcionSiDatosVacios()
    {
//        
        $msj= '{"destinatario":{"legajo":["Legajo cannot be blank."],"fecha_ingreso":["Fecha Ingreso cannot be blank."],"fecha_presentacion":["Fecha Presentacion cannot be blank."]},"nombre":["Nombre cannot be blank."],"apellido":["Apellido cannot be blank."],"nro_documento":["Nro Documento cannot be blank."],"fecha_nacimiento":["Fecha Nacimiento cannot be blank."],"estado_civilid":["Estado Civilid cannot be blank."],"sexoid":["Sexoid cannot be blank."],"generoid":["Generoid cannot be blank."],"email":["Email cannot be blank."],"calle":["Calle cannot be blank."],"altura":["Altura cannot be blank."],"localidadid":["Localidadid cannot be blank."]}';
        $this->tester->expectException(new \yii\base\Exception($msj),function(){
            $param=[];
            $model = new Destinatario;
            $model->setAttributesAndValidate($param);
        });
//        '{"destinatario":{"legajo":["Legajo cannot be blank."],"fecha_ingreso":["Fecha Ingreso cannot be blank."],"fecha_presentacion":["Fecha Presentacion cannot be blank."]},"persona":{"nombre":["Nombre cannot be blank."],"apellido":["Apellido cannot be blank."],"nro_documento":["Nro Documento cannot be blank."],"fecha_nacimiento":["Fecha Nacimiento cannot be blank."],"estado_civilid":["Estado Civilid cannot be blank."],"sexoid":["Sexoid cannot be blank."],"generoid":["Generoid cannot be blank."],"email":["Email cannot be blank."]},"lugar":{"calle":["Calle cannot be blank."],"altura":["Altura cannot be blank."],"localidadid":["Localidadid cannot be blank."]}}'
//        '{"destinatario":{"legajo":["Legajo cannot be blank."],"fecha_ingreso":["Fecha Ingreso cannot be blank."],"fecha_presentacion":["Fecha Presentacion cannot be blank."]},"persona":{"nombre":["Nombre cannot be blank."],"apellido":["Apellido cannot be blank."],"nro_documento":["Nro Documento cannot be blank."],"fecha_nacimiento":["Fecha Nacimiento cannot be blank."],"estado_civilid":["Estado Civilid cannot be blank."],"email":["Email cannot be blank."],"sexoid":["Sexoid cannot be blank."],"generoid":["Generoid cannot be blank."]},"lugar":{"calle":["Calle cannot be blank."],"altura":["Altura cannot be blank."],"localidadid":["Localidadid cannot be blank."]}}'

    }
    
    public function testDisparaExcepcionSiDatosPersonaVacios()
    {

        $msj = '{"nombre":["Nombre cannot be blank."],"apellido":["Apellido cannot be blank."],"nro_documento":["Nro Documento cannot be blank."],"fecha_nacimiento":["Fecha Nacimiento cannot be blank."],"estado_civilid":["Estado Civilid cannot be blank."],"sexoid":["Sexoid cannot be blank."],"generoid":["Generoid cannot be blank."],"email":["Email cannot be blank."],"calle":["Calle cannot be blank."],"altura":["Altura cannot be blank."],"localidadid":["Localidadid cannot be blank."]}';
        
        $this->tester->expectException(new \yii\base\Exception($msj),function(){
            $param=[
                "destinatario"=>[
                    "oficio"=> "Un oficio",
                    "calificacion"=> 7,
                    "legajo"=> "usb123/1",
                    "profesion"=>"ninguna",
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
            ];
            $model = new Destinatario;
            $model->setAttributesAndValidate($param);
        });

    }
    
    public function testDisparaExcepcionSiDatosLugarVacios()
    {
//        '{"lugar":{"calle":["Calle cannot be blank."],"altura":["Altura cannot be blank."],"localidadid":["Localidadid cannot be blank."]}}'
//        '{"persona":{"nombre":["Nombre cannot be blank."],"apellido":["Apellido cannot be blank."],"nro_documento":["Nro Documento cannot be blank."],"fecha_nacimiento":["Fecha Nacimiento cannot be blank."],"estado_civilid":["Estado Civilid cannot be blank."],"sexoid":["Sexoid cannot be blank."],"generoid":["Generoid cannot be blank."],"email":["Email cannot be blank."]},"lugar":{"calle":["Calle cannot be blank."],"altura":["Altura cannot be blank."],"localidadid":["Localidadid cannot be blank."]}}'
        
        $msj = '{"calle":["Calle cannot be blank."],"altura":["Altura cannot be blank."],"localidadid":["Localidadid cannot be blank."]}';
        
        $this->tester->expectException(new \yii\base\Exception($msj),function(){
            $param=[
                "destinatario"=>[
                    "oficio"=> "Un oficio",
                    "calificacion"=> 7,
                    "legajo"=> "usb123/1",
                    "profesion"=>"ninguna",
                    "fecha_presentacion"=>"2000-12-12",
                    "fecha_ingreso"=> "2000-12-12",
                    "origen"=> "un origen",
                    "deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
                    "deseo_actividad"=> "La actividad que desea realizar",
                    "experiencia_laboral"=> 1,
                    "banco_cbu"=> "54321987654",
                    "banco_nombre"=> "Patagonia",
                    "banco_alias"=> "CAMION-RODILLO-RUEDA",
                    "observacion"=> "Una observacion",
                    "persona"=>[
                        "nombre"=>"Carlos",
                        "apodo"=>"Kar",
                        "apellido"=>"Lopez",
                        "nro_documento"=>"36765567",
                        "fecha_nacimiento"=>"07/05/1995",
                        "estado_civilid"=>"1",
                        "telefono"=>"",
                        "celular"=>"(2920) 15412228",
                        "sexoid"=>"1",
                        "tipo_documentoid"=>1,
                        "nucleoid"=>null,
                        "situacion_laboralid"=>1,
                        "generoid"=>1,
                        "email"=>"uncorre@hotmail.com",
                    ]
                ],
                
            ];
            $model = new Destinatario;
            $model->setAttributesAndValidate($param);
        });

    }
    
    public function testDisparaExcepcionSiLegajoExiste()
    {
        $msj = '{"destinatario":{"legajo":["Legajo \"usb123\/7\" has already been taken."]}}';
        $this->tester->expectException(new \yii\base\Exception($msj),function(){
        $param=[
            "destinatario"=>[
                "oficio"=> "Un oficio",
                "calificacion"=> 7,
                "legajo"=> "usb123/7",
                "profesion"=>"ninguna",
                "fecha_presentacion"=>"2000-12-12",
                "fecha_ingreso"=> "2000-12-12",
                "origen"=> "un origen",
                "deseo_lugar_entrenamiento"=> "Donde desea realizar el entrenamiento",
                "deseo_actividad"=> "La actividad que desea realizar",
                "experiencia_laboral"=> 1,
                "banco_cbu"=> "54321987654",
                "banco_nombre"=> "Patagonia",
                "banco_alias"=> "CAMION-RODILLO-RUEDA",
                "observacion"=> "Una observacion",
                "persona"=>[
                    "nombre"=>"Carlos",
                    "apodo"=>"Kar",
                    "apellido"=>"Lopez",
                    "nro_documento"=>"36765567",
                    "fecha_nacimiento"=>"07/05/1995",
                    "estado_civilid"=>"1",
                    "telefono"=>"",
                    "celular"=>"(2920) 15412228",
                    "sexoid"=>"1",
                    "tipo_documentoid"=>1,
                    "nucleoid"=>null,
                    "situacion_laboralid"=>1,
                    "generoid"=>1,
                    "email"=>"uncorre@hotmail.com",
                    "lugar"=>[
                        "calle"=>"algo",
                        "altura"=>"321",
                        "localidadid"=>1,
                    ]
                ]
            ],
            
        ];
        $model = new Destinatario;
        $model->setAttributesAndValidate($param);
        });

    }
}