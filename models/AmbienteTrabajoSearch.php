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

        return $dataProvider;
    }
}