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
            [['id', 'calificacion', 'personaid', 'experiencia_laboral'], 'integer'],
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
            'calificacion' => $this->calificacion,
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
    public function busquedadGeneral($params = array())
    {
        $personaForm = new PersonaForm();
        $query = Destinatario::find();
        $pagesize = (!isset($params['pagesize']) || !is_numeric($params['pagesize']) || $params['pagesize']==0)?20:intval($params['pagesize']);
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pagesize,
                'page' => (isset($params['page']) && is_numeric($params['page']))?$params['page']:0
            ],
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        /********** Se Obtiene una coleccion de Personas **********/
        if(isset($params['global_param']) && !empty($params['global_param'])){
            $persona_params["global_param"] = $params['global_param'];
        }
        
        if(isset($params['localidadid']) && !empty($params['localidadid'])){
            $persona_params['localidadid'] = $params['localidadid'];
        }
        
        if(isset($params['calle']) && !empty($params['calle'])){
            $persona_params['calle'] = $params['calle'];    
        }
        
        $coleccion_persona = array();
        $lista_personaid = array();
        if (isset($persona_params)) {
            
            $coleccion_persona = $personaForm->buscarPersonaEnRegistral($persona_params);
            $lista_personaid = $this->obtenerListaIds($coleccion_persona);

            if (count($lista_personaid) < 1) {
                $query->where('0=1');
            }
        }
        /********** Fin de coleccion de Personas **************/
        
        
        /*********** Se filtran los Destinatarios **************/
        
        
        if(isset($params['ids'])){
            #Se realiza un filtrado de multiples ids
            $lista_id = explode(",", $params['ids']);
            $query->andWhere(array('in', 'id', $lista_id));
        }else{
            #Se realiza un filtrado con los siguientes criterios
            $query->andFilterWhere([
                'id' => $this->id,
                'calificacion' => $this->calificacion,
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




            #Criterio de lista de personas.... lista de personaid
            if(count($lista_personaid)>0){
                $query->andWhere(array('in', 'personaid', $lista_personaid));
            }
        }
        
        /******************** Fin de filtrado de Destinatarios **************/
        
        /******* Se obtiene la coleccion de Destinaraios filtrados ******/
        $coleccion_destinatario = array();
        foreach ($dataProvider->getModels() as $value) {
            $coleccion_destinatario[] = $value->toArray();
        }
        
        /************ Se vincunlan las personas correspondiente a cada Desinatario ****************/
        if(count($coleccion_persona)>0){
            $coleccion_destinatario = $this->vincularPersona($coleccion_destinatario, $coleccion_persona);
        }else{
            $coleccion_persona = $this->obtenerPersonaVinculada($coleccion_destinatario);
            $coleccion_destinatario = $this->vincularPersona($coleccion_destinatario, $coleccion_persona);
        } 
        
        $paginas = ceil($dataProvider->totalCount/$pagesize);           
        $data['pagesize']=$pagesize;            
        $data['pages']=$paginas;    
        $data['total_filtrado']=$dataProvider->totalCount;
        $data['success']=(count($coleccion_destinatario)>0)?true:false;
        $data['resultado']=$coleccion_destinatario;
        
        return $data;
    }
    
    /**
     * De una coleccion de persona, se obtienen una lista de ids
     * @param array $coleccion lista de personas
     * @return array
     */
    private function obtenerListaIds($coleccion = array()) {
        
        $lista_ids = array();
        foreach ($coleccion as $col) {
            $lista_ids[] = $col['id'];
        }
        
        return $lista_ids;    
    }
    
    /**
     * Se vinculan las personas a la lista de destinatarios
     * @param array $coleccion_destinatario
     * @param array $coleccion_persona
     * @return array
     */
    private function vincularPersona($coleccion_destinatario = array(), $coleccion_persona = array()) {
        $i=0;
        foreach ($coleccion_destinatario as $destinatario) {
            foreach ($coleccion_persona as $persona) {
                if(isset($destinatario['personaid']) && isset($persona['id']) && $destinatario['personaid']==$persona['id']){                    
                    $destinatario['persona'] = $persona;
                    $destinatario['persona']['ultimo_estudio'] = $this->getUltimoEstudio($persona['estudios']);
                    $coleccion_destinatario[$i] = $destinatario;
                }
            }
            $i++;
        }
        
        return $coleccion_destinatario;
    }
    
    /**
     * Devolvemos el ultimo estudio realizado
     * @param array $estudios
     */
    private function getUltimoEstudio($estudios){
        $primera_vez = true;
        $ultimo = array();
        foreach ($estudios as $value) {
            if($primera_vez){
                $ultimo = $value;
                $primera_vez = false;
            }
            $ultimo = (intval($ultimo['anio'])>intval($value['anio']))?$ultimo:$value;
        }
        
        return $ultimo;
    }


    /**
     * Se obtienen las persoans que están vinculados a la lista de destinatarios
     * @param array $coleccion_destinatario
     * @return array
     */
    private function obtenerPersonaVinculada($coleccion_destinatario = array()) {
        $personaForm = new PersonaForm();
        $ids='';
        foreach ($coleccion_destinatario as $destinatario) {
            $ids .= (empty($ids))?$destinatario['personaid']:','.$destinatario['personaid'];
        }
        
        $coleccion_persona = $personaForm->buscarPersonaEnRegistral(array("ids"=>$ids));
        
        return $coleccion_persona;
    }
}
