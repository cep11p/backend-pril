<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AmbienteTrabajo;

/**
* AmbienteTrabajoSearch represents the model behind the search form about `app\models\AmbienteTrabajo`.
*/
class AmbienteTrabajoSearch extends AmbienteTrabajo
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['id', 'calificacion', 'personaid', 'tipo_ambiente_trabajoid', 'lugarid'], 'integer'],
            [['nombre', 'legajo', 'observacion', 'cuit', 'actividad'], 'safe'],
        ];
    }

    /**
    * @inheritdoc
    */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
    * Creates data provider instance with search query applied
    *
    * @param array $params
    *
    * @return ActiveDataProvider
    */
    public function search($params)
    {
        $query = AmbienteTrabajo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'calificacion' => $this->calificacion,
            'personaid' => $this->personaid,
            'tipo_ambiente_trabajoid' => $this->tipo_ambiente_trabajoid,
            'lugarid' => $this->lugarid,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'cuit', $this->cuit])
            ->andFilterWhere(['like', 'actividad', $this->actividad]);

        return $dataProvider;
    }
    
    public function busquedadGeneral($params)
    {
        $query = AmbienteTrabajo::find();
        $lugarForm = new LugarForm();
        $personaForm = new PersonaForm();
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
                'page' => (isset($params['page']) && is_numeric($params['page']))?$params['page']:0
            ],
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'calificacion' => $this->calificacion,
            'personaid' => $this->personaid,
            'tipo_ambiente_trabajoid' => $this->tipo_ambiente_trabajoid,
            'lugarid' => $this->lugarid,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'cuit', $this->cuit])
            ->andFilterWhere(['like', 'actividad', $this->actividad]);
        
        /*** Filtrado por Lugar (tabla con registros de geolocalizacion y georeferencias)****/
        
        #Localidad
        if(isset($params['localidadid']) && !empty($params['localidadid'])){
            $lugar_params['localidadid'] = $params['localidadid'];
        }
        
        #Calle
        if(isset($params['calle']) && !empty($params['calle'])){
            $lugar_params['calle'] = $params['calle'];    
        }
        
        #coleccionamos ids
        $lugar_listaid = array();
        if(isset($lugar_params)){
            $coleccionLugar = $lugarForm->buscarLugarEnSistemaLugar($lugar_params);
            
            if($coleccionLugar){
                foreach ($coleccionLugar as $array) {
                    $lugar_listaid[] = $array['id'];
                }
            }else{
                $query->where('0=1');
            }
            
        }
        
        #filtramos por ids de lugar
        if(count($lugar_listaid)>0){
            $query->andWhere(array('in', 'lugarid', $lugar_listaid));
        }
        
        /************** Filtrando por Persona(representante del A.T) **********************/
        if(isset($params['global_param']) && !empty($params['global_param'])){
            $persona_params["global_param"] = $params['global_param'];
        }
        
        
        $persona_listaid = array();
        if(isset($persona_params)){
            $coleccionPersonas = $personaForm->buscarPersonaEnRegistral($persona_params);
            
            if($coleccionPersonas){
                foreach ($coleccionPersonas as $persona) {
                    $persona_listaid[] = $persona['id'];
                }
            }else{
                $query->where('0=1');
            }
            
        }
        
        if(count($persona_listaid)>0){
            $query->andWhere(array('in', 'personaid', $persona_listaid));
        }

        return $dataProvider;
    }
}