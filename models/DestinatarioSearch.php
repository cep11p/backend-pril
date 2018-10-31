<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Destinatario;

/**
 * DestinatarioSearch represents the model behind the search form of `app\models\Destinatario`.
 */
class DestinatarioSearch extends Destinatario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'oficioid', 'calificacion', 'profesionid', 'personaid', 'experiencia_laboral'], 'integer'],
            [['legajo', 'fecha_ingreso', 'origen', 'observacion', 'deseo_lugar_entrenamiento', 'deseo_actividad', 'fecha_presentacion', 'banco_cbu', 'banco_nombre', 'banco_alias', 'conocimientos_basicos'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Destinatario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'oficioid' => $this->oficioid,
            'calificacion' => $this->calificacion,
            'profesionid' => $this->profesionid,
            'fecha_ingreso' => $this->fecha_ingreso,
            'fecha_presentacion' => $this->fecha_presentacion,
            'personaid' => $this->personaid,
            'experiencia_laboral' => $this->experiencia_laboral,
        ]);

        $query->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['like', 'origen', $this->origen])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'deseo_lugar_entrenamiento', $this->deseo_lugar_entrenamiento])
            ->andFilterWhere(['like', 'deseo_actividad', $this->deseo_actividad])
            ->andFilterWhere(['like', 'banco_cbu', $this->banco_cbu])
            ->andFilterWhere(['like', 'banco_nombre', $this->banco_nombre])
            ->andFilterWhere(['like', 'banco_alias', $this->banco_alias])
            ->andFilterWhere(['like', 'conocimientos_basicos', $this->conocimientos_basicos]);

        return $dataProvider;
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function busquedadGeneral($params)
    {
        $query = Destinatario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'oficioid' => $this->oficioid,
            'calificacion' => $this->calificacion,
            'profesionid' => $this->profesionid,
            'fecha_ingreso' => $this->fecha_ingreso,
            'fecha_presentacion' => $this->fecha_presentacion,
            'personaid' => $this->personaid,
            'experiencia_laboral' => $this->experiencia_laboral,
        ]);

        $query->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['like', 'origen', $this->origen])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'deseo_lugar_entrenamiento', $this->deseo_lugar_entrenamiento])
            ->andFilterWhere(['like', 'deseo_actividad', $this->deseo_actividad])
            ->andFilterWhere(['like', 'banco_cbu', $this->banco_cbu])
            ->andFilterWhere(['like', 'banco_nombre', $this->banco_nombre])
            ->andFilterWhere(['like', 'banco_alias', $this->banco_alias])
            ->andFilterWhere(['like', 'conocimientos_basicos', $this->conocimientos_basicos]);

        return $dataProvider;
    }
}