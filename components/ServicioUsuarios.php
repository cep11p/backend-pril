<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;
use dektrium\user\models\User;

/**
 * Description of ServicioUsuarios
 *
 * @author carlos
 */
class ServicioUsuarios {
    //put your code here
    
    public static function userFilterCallback($username)
    {
        $usr = User::find()->where(['username'=>$username])->one();
        if($usr)
            return $usr->id;
        return null;
    }
    
    public static function userIdentifierCallback($userId)
    {
        $usr = User::findOne($userId);
        if($usr)
            return $usr->username;
        return null;        
    }
}
