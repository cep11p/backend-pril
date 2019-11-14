<?php

namespace app\models;

use Yii;
use \app\models\base\Oferta as BaseOferta;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "oferta".
 */
class Oferta extends BaseOferta
{
    const ESTADO_VACANTE = 'vacante';
    const ESTADO_VIGENTE = 'vigente';
    const ESTADO_FINALIZADA = 'finalizada';

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
                ['lugarid', 'compare','compareValue'=>0,'operator'=>'!=','message' => 'No se pudo registrar el Lugar correctamente en el Sistema Lugar.'],
            ]
        );
    }
    
    public function getLugar() {
        $lugar = new LugarForm();
        
        $resultado = $lugar->buscarLugarPorIdEnSistemaLugar($this->lugarid);
        
        return $resultado;
        
    }
    
    /**
     * Devolvemos el area de entrenamiento donde se encuentra la oferta
     * @return object AreaEntrenamiento
     */
    public function getAreaEntrenamiento()
    {
        return $this->hasOne(\app\models\AreaEntrenamiento::className(), ['ofertaid' => 'id']);
    }
    
    /**
     * Realizamos un metodo para obtener el estado logico de oferta
     * @return string
     */
    public function getEstado() {
        $estado = '';
        
        if($this->areaEntrenamiento->id == null){
            $estado = Oferta::ESTADO_VACANTE;
        }
        if(($this->areaEntrenamiento->fecha_final==null || $this->areaEntrenamiento->fecha_final > date('Y-m-d')) && $this->areaEntrenamiento->id != null){
            $estado = Oferta::ESTADO_VIGENTE;
        }
        if(($this->areaEntrenamiento->fecha_final != null && $this->areaEntrenamiento->fecha_final < date('Y-m-d')) && $this->areaEntrenamiento->id != null){
            $estado = Oferta::ESTADO_FINALIZADA;
        }

        return $estado;        
    }
    
    public function fields()
    {        
        $resultado = ArrayHelper::merge(parent::fields(), [
            'lugar'=> function($model){
                return $model->lugar;
            },
            'ambiente_trabajo'=> function($model){
                return $model->ambienteTrabajo->nombre;
            },
            'estado'=> function($model){
                return $model->estado;
            }
        ]);
        
        return $resultado;
    
    }
}
