<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;
use yii\helpers\ArrayHelper;

class Help extends \yii\base\Component{
    
    public static function obtenerEdad($fecha_nacimiento)
    {
        
        list($anioCumple,$mesCumple,$diaCumple)=explode("-", $fecha_nacimiento);
        list($anioHoy,$mesHoy,$diaHoy)=explode("-", date('Y-m-d'));


        $edad = intval($anioHoy) - intval($anioCumple);
        if(intval($diaCumple) >= intval($diaHoy)){//diaCumple mayor
            if(intval($mesCumple) > intval($mesHoy)){
                $edad--;
            }
        }else{ //diaCumple menor
            if(intval($mesCumple) > intval($mesHoy)){
                $edad--;
            }
            
        }

        return strval($edad);
    }
    
    /**
     * Vamos a extrar un array de una array por las keys seteadas
     * @param array $array_principal
     * @param array $param Esto es un array de Keys
     * @author cep11p
     */
    public static function extraerArrayDeArrayAsociativo($array_principal, $array_keys)
    {
        $array = array();
        foreach ($array_keys as $index){
            
            foreach ($array_principal as $key => $value) {
                if($index == $key){
                    $array = ArrayHelper::merge($array, [$key=>$value]);
                    break;
                }
            }  
        }
        return $array;
    }
}