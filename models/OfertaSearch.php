<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Oferta;

/**
* OfertaSearch represents the model behind the search form about `app\models\Oferta`.
*/
class OfertaSearch extends Oferta
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['id', 'ambiente_trabajoid', 'lugarid'], 'integer'],
            [['nombre_sucursal', 'puesto', 'area', 'fecha_inicial', 'fecha_final', 'demanda_laboral', 'objetivo', 'dia_horario', 'tarea'], 'safe'],
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
        $query = Oferta::find();

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
            'ambiente_trabajoid' => $this->ambiente_trabajoid,
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_final' => $this->fecha_final,
            'lugarid' => $this->lugarid,
        ]);

        $query->andFilterWhere(['like', 'nombre_sucursal', $this->nombre_sucursal])
            ->andFilterWhere(['like', 'puesto', $this->puesto])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'demanda_laboral', $this->demanda_laboral])
            ->andFilterWhere(['like', 'objetivo', $this->objetivo])
            ->andFilterWhere(['like', 'dia_horario', $this->dia_horario])
            ->andFilterWhere(['like', 'tarea', $this->tarea]);

        return $dataProvider;
    }
    
    public function busquedadGeneral($params)
    {
        $query = Oferta::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'ambiente_trabajoid' => $this->ambiente_trabajoid,
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_final' => $this->fecha_final,
            'lugarid' => $this->lugarid,
        ]);

        $query->andFilterWhere(['like', 'nombre_sucursal', $this->nombre_sucursal])
            ->andFilterWhere(['like', 'puesto', $this->puesto])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'demanda_laboral', $this->demanda_laboral])
            ->andFilterWhere(['like', 'objetivo', $this->objetivo])
            ->andFilterWhere(['like', 'dia_horario', $this->dia_horario])
            ->andFilterWhere(['like', 'tarea', $this->tarea]);

        return $dataProvider;
    }
}