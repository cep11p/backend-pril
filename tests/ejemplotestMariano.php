 <?php
 
    $manager = $this->getMockBuilder('yii\rbac\PhpManager')
        ->setMethods(['checkAccess'])
        ->getMock();        
    $manager->expects($this->any())->method('checkAccess')->willReturn(TRUE);        
    \Yii::$app->set('authManager', $manager);

    // cargar fixture
    $logger = $this->getMockBuilder('yii\\log\\Logger')
        ->setMethods(['log'])
        ->getMock();        
     \Yii::setLogger($logger);
    $logger->expects($this->any())->method('log')->willReturnCallback(function() use (&$arrayLogs){
        $parametros = func_get_args();
        $arrayLogs[] = $parametros;
    });
    //die(\yii\helpers\VarDumper::dumpAsString($arrayLogs));
    $headers = [
        'Authorization' => 'Bearer ' . $this->jwtToken
    ];
    $response = $client->request('POST', $this->base_uri . '/proveidos', ['json' => $proveido, 'headers' => $headers]);
