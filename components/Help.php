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
     * @param array $arrays_colection es la coleccion de arrays que se obtiene para filtrar
     * @param array $array_search array a buscar
     * @return array
     * @author cep11p
     */
    public static function filtrarArrayAsociativo($arrays_colection, $array_search)
    {
        
        $resultado = null;
        $array_search = array_filter($array_search);
                
        foreach ($arrays_colection as $array) {
            
            $array = array_filter($array);
            $array_found = $array;
            unset($array['id']);
            
            if($array == $array_search){
                $resultado = $array_found;
            }
        }  
        
        return $resultado;
    }
    
    /*
    * filtering an array
    */
    public static function filter_by_value ($array, $index, $value){
        $resultado = array();
        if(is_array($array) && count($array)>0) 
        {
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];
                
                if ($temp[$key] == $value){
                    $resultado[] = $array[$key];
                }
            }
          }
        return $resultado;
    } 
}