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
        
        /******** SE OBTIENE COLECCION de Lugar (tabla con registros de geolocalizacion y georeferencias) **********/
        
        #Localidad
        if(isset($params['localidadid']) && !empty($params['localidadid'])){
            $lugar_params['localidadid'] = $params['localidadid'];
        }
        
        #Calle
        if(isset($params['calle']) && !empty($params['calle'])){
            $lugar_params['calle'] = $params['calle'];    
        }
        
        $coleccion_lugar = array();
        $lista_lugarid = array();
        if (isset($lugar_params)) {
            
            $coleccion_lugar = $lugarForm->buscarLugarEnSistemaLugar($lugar_params);
            $lista_lugarid = $this->obtenerListaIds($coleccion_lugar);

            if (count($lista_lugarid) < 1) {
                $query->where('0=1');
            }
        }
        
        /************** SE OBTIENE COLECCION de Personas(representante del A.T) **********************/
        if(isset($params['global_param']) && !empty($params['global_param'])){
            $global_params = $params['global_param'];
        }
        
        
        $coleccion_persona = array();
        $lista_personaid = array();
        if (isset($global_params)) {
            
            //Se busca en registral
            $coleccion_persona = $personaForm->buscarPersonaEnRegistral(['global_param'=>$global_params]);
            $lista_personaid = $this->obtenerListaIds($coleccion_persona);
            if (count($lista_personaid) < 1) {
                $query->where('0=1');
            }
            
            //buscamos en nombre de ambiente trabajo
            $query->andFilterWhere(['like', 'nombre', $global_params]);
        }
        
        
        /**** Se filtran los ambiente de trabajo *********/
        $query->andFilterWhere([
            'id' => $this->id,
            'calificacion' => $this->calificacion,
            'personaid' => $this->personaid,
            'tipo_ambiente_trabajoid' => $this->tipo_ambiente_trabajoid,
            'lugarid' => $this->lugarid,
        ]);
        
        #filtramos por ids de personas
        if(count($lista_personaid)>0){
            $query->orWhere(array('in', 'personaid', $lista_personaid));
        }
        
        #filtramos por ids de lugar
        if(count($lista_lugarid)>0){
            $query->andWhere(array('in', 'lugarid', $lista_lugarid));
        }
        /*********** FIN de filtrado de ambiente de trabajo ***********/
        
        /******* SE OBTIENE los Ambiente de trabajos filtrados  como array******/
        $coleccion_ambiente_trabajo = array();
        foreach ($dataProvider->getModels() as $value) {
            $coleccion_ambiente_trabajo[] = $value->toArray();
        }
        
        /************ Se vincunlan las personas correspondiente a cada ambiente de trabajo ****************/
        if(count($coleccion_persona)>0){
            $coleccion_ambiente_trabajo = $this->vincularPersona($coleccion_ambiente_trabajo, $coleccion_persona);
        }else{
            $coleccion_persona = $this->obtenerPersonaVinculada($coleccion_ambiente_trabajo);
            $coleccion_ambiente_trabajo = $this->vincularPersona($coleccion_ambiente_trabajo, $coleccion_persona);
        } 
        
        /************ Se vincunlan los lugares correspondiente a cada ambiente de trabajo ****************/
        if(count($coleccion_lugar)>0){
            $coleccion_ambiente_trabajo = $this->vincularLugar($coleccion_ambiente_trabajo, $coleccion_lugar);
        }else{
            $coleccion_lugar = $this->obtenerLugarVinculado($coleccion_ambiente_trabajo);
            $coleccion_ambiente_trabajo = $this->vincularLugar($coleccion_ambiente_trabajo, $coleccion_lugar);
        } 
        
        $paginas = ceil($dataProvider->totalCount/$pagesize);           
        $data['pagesize']=$pagesize;            
        $data['pages']=$paginas; 
        $data['total_filtrado']=$dataProvider->totalCount;
        $data['success']=(count($coleccion_ambiente_trabajo)>0)?true:false;
        $data['resultado']=$coleccion_ambiente_trabajo;
        
        return $data;
        

    }
    
    /**
     * Se vinculan las personas a la lista de ambiente de trabajo
     * @param array $coleccion_ambiente_trabajo
     * @param array $coleccion_persona
     * @return array
     */
    private function vincularPersona($coleccion_ambiente_trabajo = array(), $coleccion_persona = array()) {
        $i=0;
        foreach ($coleccion_ambiente_trabajo as $ambiente_trabajo) {
            foreach ($coleccion_persona as $persona) {
                if(isset($ambiente_trabajo['personaid']) && isset($persona['id']) && $ambiente_trabajo['personaid']==$persona['id']){ 
                    
                    #sacamos datos irrelevantes para el representante del ambiente de trabajo
                    unset($persona['lugar']);
                    unset($persona['estudios']);
                    
                    $ambiente_trabajo['persona'] = $persona;
                    $coleccion_ambiente_trabajo[$i] = $ambiente_trabajo;
                }
            }
            $i++;
        }
        
        return $coleccion_ambiente_trabajo;
    }
    
    /**
     * Se obtienen las persoans que están vinculados a la lista de destinatarios
     * @param array $coleccion_ambiente_trabajo
     * @return array
     */
    private function obtenerPersonaVinculada($coleccion_ambiente_trabajo = array()) {
        $personaForm = new PersonaForm();
        $ids='';
        foreach ($coleccion_ambiente_trabajo as $ambiente_trabajo) {
            $ids .= (empty($ids))?$ambiente_trabajo['personaid']:','.$ambiente_trabajo['personaid'];
        }
        
        $coleccion_persona = $personaForm->buscarPersonaEnRegistral(array("ids"=>$ids));
        
        return $coleccion_persona;
    }
    
    /**
     * Se vinculan los lugares a la lista de ambiente de trabajo
     * @param array $coleccion_ambiente_trabajo
     * @param array $coleccion_lugar
     * @return array
     */
    private function vincularLugar($coleccion_ambiente_trabajo = array(), $coleccion_lugar = array()) {
        $i=0;
        foreach ($coleccion_ambiente_trabajo as $ambiente_trabajo) {
            foreach ($coleccion_lugar as $lugar) {
                if(isset($ambiente_trabajo['lugarid']) && isset($lugar['id']) && $ambiente_trabajo['lugarid']==$lugar['id']){                    
                    $ambiente_trabajo['lugar'] = $lugar;
                    $coleccion_ambiente_trabajo[$i] = $ambiente_trabajo;
                }
            }
            $i++;
        }
        
        return $coleccion_ambiente_trabajo;
    }
    
    /**
     * Se obtienen las persoans que están vinculados a la lista de destinatarios
     * @param array $coleccion_ambiente_trabajo
     * @return array
     */
    private function obtenerLugarVinculado($coleccion_ambiente_trabajo = array()) {
        $lugarForm = new LugarForm();
        $ids='';
        foreach ($coleccion_ambiente_trabajo as $ambiente_trabajo) {
            $ids .= (empty($ids))?$ambiente_trabajo['lugarid']:','.$ambiente_trabajo['lugarid'];
        }
        
        $coleccion_lugar = $lugarForm->buscarLugarEnSistemaLugar(array("ids"=>$ids));
        
        return $coleccion_lugar;
    }
    
    
    /**
     * De una coleccion, se obtienen una lista de ids
     * @param array $coleccion lista de Lugar
     * @return array
     */
    private function obtenerListaIds($coleccion = array()) {
        
        $lista_ids = array();
        foreach ($coleccion as $col) {
            $lista_ids[] = $col['id'];
        }
        
        return $lista_ids;    
    }
}