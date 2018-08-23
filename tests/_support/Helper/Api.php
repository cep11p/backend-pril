<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{
    public function generarToken($usuario = 'admin',$id = 1) {
        $payload = [
            'exp'=>time()+3600,
            'usuario'=>$usuario,
            'uid' => $id,
        ];
        
        $token = \Firebase\JWT\JWT::encode($payload, \Yii::$app->params['JWT_SECRET']);     
        
        return $token;
    }
}
