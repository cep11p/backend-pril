<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Role;

/**
* RolesSearch represents the model behind the search form about `app\models\Role`.
*/
class RolesSearch extends Role
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['name', 'description', 'rule_name', 'data'], 'safe'],
            [['type', 'created_at', 'updated_at'], 'integer'],
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
        $query = Role::find();
        $pagesize = (!isset($params['pagesize']) || !is_numeric($params['pagesize']) || $params['pagesize']==0)?20:intval($params['pagesize']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pagesize,
                'page' => (isset($params['page']) && is_numeric($params['page']))?$params['page']:0
            ],
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
        // uncomment the following line if you do not want to any records when validation fails
        // $query->where('0=1');
        return $dataProvider;
    }

    $query->andFilterWhere([
        'type' => $this->type,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
    ]); 

    $query->andFilterWhere(['like', 'name', $this->name])
        ->andFilterWhere(['like', 'description', $this->description])
        ->andFilterWhere(['like', 'rule_name', $this->rule_name])
        ->andFilterWhere(['like', 'data', $this->data]);
    
    $coleccion = array();
    foreach ($dataProvider->getModels() as $value) {
        $coleccion[] = $value->toArray();
    }
            
    $paginas = ceil($dataProvider->totalCount/$pagesize);           
    $data['pagesize']=$pagesize;            
    $data['pages']=$paginas;    
    $data['total_filtrado']=$dataProvider->totalCount;
//    $data['success']=(count($coleccion_destinatario)>0)?true:false;
    $data['resultado']=$coleccion;

    return $data;

//    return $dataProvider;
    }
}