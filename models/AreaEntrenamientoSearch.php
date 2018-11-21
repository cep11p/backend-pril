<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AreaEntrenamiento;

/**
* AreaEntrenamientoSearch represents the model behind the search form about `app\models\AreaEntrenamiento`.
*/
class AreaEntrenamientoSearch extends AreaEntrenamiento
{
/**
* @inheritdoc
*/
public function rules()
{
    return [
        [['id', 'planid', 'destinatarioid', 'ofertaid'], 'integer'],
        [['tarea', 'fecha_inicial', 'fecha_final', 'descripcion_baja'], 'safe'],
    ];
    }

    /**
    * @inheritdoc
    */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
    $scenarios["search"] = ['id'];

    return $scenarios;
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
        $query = AreaEntrenamiento::find();

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
            'planid' => $this->planid,
            'destinatarioid' => $this->destinatarioid,
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_final' => $this->fecha_final,
            'ofertaid' => $this->ofertaid,
        ]);

        $query->andFilterWhere(['like', 'tarea', $this->tarea])
              ->andFilterWhere(['like', 'descripcion_baja', $this->descripcion_baja]);

        return $dataProvider;
    }
    
    public function busquedadGeneral($params)
    {
        $personaForm = new PersonaForm();
        $query = AreaEntrenamiento::find();

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
            'planid' => $this->planid,
            'destinatarioid' => $this->destinatarioid,
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_final' => $this->fecha_final,
            'ofertaid' => $this->ofertaid,
        ]);

        $query->andFilterWhere(['like', 'tarea', $this->tarea])
              ->andFilterWhere(['like', 'descripcion_baja', $this->descripcion_baja]);
        
        
        /*********** Filtramos por Destinatario/Persona ********************/
        $coleccion_personaid = array();
        
        if(isset($params['global_param']) && !empty($params['global_param'])){
            $persona_params["global_param"] = $params['global_param'];
        }
        
        if(isset($params['localidadid']) && !empty($params['localidadid'])){
            $persona_params['localidadid'] = $params['localidadid'];
        }
        
        if(isset($params['calle']) && !empty($params['calle'])){
            $persona_params['calle'] = $params['calle'];    
        }
        
        if(isset($persona_params)){
            $coleccionPersonas = $personaForm->buscarPersonaEnRegistral($persona_params);
            
            if($coleccionPersonas){
                foreach ($coleccionPersonas as $persona) {
                    $coleccion_personaid[] = $persona['id'];
                }
            }else{
                $query->where('0=1');
            }
            
        }
        
        if(count($coleccion_personaid)>0){
            $query->leftJoin("destinatario as d", "destinatarioid=d.id");
            
            $query->andWhere(array('in', 'd.personaid', $coleccion_personaid));
        }
        
        /******************** FIN del filtrado por Persona ****************/

        return $dataProvider;
    }
}