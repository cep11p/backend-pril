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
            [['nombre_sucursal', 'puesto', 'area', 'fecha_inicial', 'fecha_final', 'demanda_laboral', 'objetivo'], 'safe'],
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
            'pagination' => [
                'pageSize' => 10,
                'page' => (isset($params['page']) && is_numeric($params['page']))?$params['page']:0
            ],
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
            ->andFilterWhere(['like', 'objetivo', $this->objetivo]);

        return $dataProvider;
    }
    
    public function busquedadGeneral($params)
    {
        $query = Oferta::find();
        $pagesize = (!isset($params['pagesize']) || !is_numeric($params['pagesize']) || $params['pagesize']==0)?20:intval($params['pagesize']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pagesize,
                'page' => (isset($params['page']) && is_numeric($params['page']))?$params['page']:0
            ],
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if($params['ids']){
            #Se realiza un filtrado de multiples ids
            $lista_id = explode(",", $params['ids']);
            $query->andWhere(array('in', 'id', $lista_id));
        }else{
            #Se realiza un filtrado con los siguientes criterios
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
                ->andFilterWhere(['like', 'objetivo', $this->objetivo]);
        }
        
        $coleccion_oferta = array();
        foreach ($dataProvider->getModels() as $value) {
            if(!$params['estado']){
                $coleccion_oferta[] = $value->toArray();
            }
            
            //Se filtra por estado
            if($value->estado == strtolower($params['estado'])){
                    $coleccion_oferta[] = $value->toArray();
            }
            
        }
        
        $paginas = ceil($dataProvider->totalCount/$pagesize);           
        $data['pagesize']=$pagesize;            
        $data['pages']=$paginas;
        $data['total_filtrado']= count($coleccion_oferta);
        $data['success']=(count($coleccion_oferta)>0)?true:false;
        $data['resultado']=$coleccion_oferta;
        
        return $data;
    }
//    public function busquedadGeneral($params)
//    {
//        $query = Oferta::find();
//        $query->select([
//            'oferta.*',
//            "(SELECT a.id  FROM oferta LEFT JOIN `area_entrenamiento` `a` ON oferta.id=a.ofertaid ) as estado"
//        ]);
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        $this->load($params,'');
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//        
//        if($params['ids']){
//            #Se realiza un filtrado de multiples ids
//            $lista_id = explode(",", $params['ids']);
//            $query->andWhere(array('in', 'id', $lista_id));
//        }else{
//            #Se realiza un filtrado con los siguientes criterios
//            $query->andFilterWhere([
//                'id' => $this->id,
//                'ambiente_trabajoid' => $this->ambiente_trabajoid,
//                'fecha_inicial' => $this->fecha_inicial,
//                'fecha_final' => $this->fecha_final,
//                'lugarid' => $this->lugarid,
//            ]);
//
//            $query->andFilterWhere(['like', 'nombre_sucursal', $this->nombre_sucursal])
//                ->andFilterWhere(['like', 'puesto', $this->puesto])
//                ->andFilterWhere(['like', 'area', $this->area])
//                ->andFilterWhere(['like', 'demanda_laboral', $this->demanda_laboral])
//                ->andFilterWhere(['like', 'objetivo', $this->objetivo]);
//        }
//
//        $query->leftJoin('area_entrenamiento as a', 'oferta.id=a.ofertaid');
//        /******* Se obtiene la coleccion filtrada******/
//        $coleccion_oferta = array();
//        $command = $query->createCommand();
////        print_r($command->sql);die();
//        $rows = $command->queryAll();
//        
//        if($params['estado']){
//            foreach ($rows as $value) {
//                switch ($params['estado']) {
//                    case Oferta::ESTADO_VACANTE:
//                        if($value->areaEntrenamiento->id == null){
//                            $coleccion_oferta[] = $value;
//                        }
//                        break;
//                    case Oferta::ESTADO_VIGENTE:
//                        
//                        print_r($value);
//                        die();
//                        break;
//                    case Oferta::ESTADO_FINALIZADA:
//                        echo "i es igual a 2";
//                        break;
//                }
//            }
//        }
//        
//        print_r($coleccion_oferta);die();
//        
//        
//        
//        
//        
//        
//        
//        
//        
//        
//        
//        
//        
//        foreach ($dataProvider->getModels() as $value) {
//            if(!$params['estado']){
//                $coleccion_oferta[] = $value->toArray();
//            }
//            
//            if($params['estado'] && $params['estado']==Oferta::ESTADO_VACANTE){
//                if($value->areaEntrenamiento->id == null){
//                    $coleccion_oferta[] = $value->toArray();
//                }
//            }
//            if($params['estado'] && $params['estado']==Oferta::ESTADO_VIGENTE){
//                if(($value->areaEntrenamiento->fecha_final==null || $value->areaEntrenamiento->fecha_final > date('Y-m-d')) && $value->areaEntrenamiento->id != null){
//                    $coleccion_oferta[] = $value->toArray();
//                }
//            }
//            if($params['estado'] && $params['estado']==Oferta::ESTADO_FINALIZADA){
//                if(($value->areaEntrenamiento->fecha_final != null && $value->areaEntrenamiento->fecha_final < date('Y-m-d')) && $value->areaEntrenamiento->id != null){
//                    $coleccion_oferta[] = $value->toArray();
//                }
//            }
//            
//        }
//        
////        print_r($coleccion_oferta);die();
//        $data['total_filtrado']= count($coleccion_oferta);
//        $data['success']=(count($coleccion_oferta)>0)?true:false;
//        $data['resultado']=$coleccion_oferta;
//        
//        return $data;
//    }
}