<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

/**
 *
 * @author carlos
 */
interface IServicioRegistral {
    
   
    /**
     *
     * @param string $legajo
     * @param string $organismo
     * @param string $fiscalAnterior
     * @param string $fiscalActual
     * @return string $id Es el id de la persona
     */
    public function crearPersona($data);
    
    public function actualizarPersona($data);
    
    public function buscarPersonaPorNroDocumento($nrodocumento);
    
    public function buscarPersonaPorId($id);
    
    
    /**
     * Busca el nucleo que tenga el mismo hogarid y con el nombre = 'Predeterminado'
     * @param int $hogarid
     * @param string $nombre
     * @return obtenemos una respuesta de registral
     */
    public function buscarNucleo($param);
    
    public function buscarNucleoPorId($id);
    
    public function buscarNivelEducativoPorId($id);
    
    

    public function buscarHogar($param);
    
    public function buscarPersona($param);
    
    /**
     * Se devuelve una coleccion de Sexos.
     * NOTA!... Hay que tener en cuenta que el SexoController del sistema Registral no soporta filtrado, es decir que los parametros enviados va a ser inrrelevantes
     * @param array $param
     * @return boolean
     */
    public function buscarSexo($param);
    
    /**
     * Se devuelve una coleccion de Genero.
     * NOTA!... Hay que tener en cuenta que el GeneroController del sistema Registral no soporta filtrado, es decir que los parametros enviados va a ser inrrelevantes
     * @param array $param
     * @return boolean
     */
    public function buscarGenero($param);
    
    /**
     * Se devuelve una coleccion de Estados Civiles.
     * NOTA!... Hay que tener en cuenta que el EstadoCivilController del sistema Registral no soporta filtrado, es decir que los parametros enviados va a ser inrrelevantes
     * @param array $param
     * @return boolean
     */
    public function buscarEstadoCivil($param);
    
    /**
     * crear un string con los criterio de busquedad por ejemplo: localidadid=1&calle=mata negra&altura=123
     * @param array $param
     * @return string
     */
    public function crearCriterioBusquedad($param);
    
    
    /**
     * 
     * @param int $nro_documento
     * @return int personaid
     */
    public static function buscarPersonaEnRegistralPorNumeroDocuemento($nro_documento);
   //put your code here
    
    
}
