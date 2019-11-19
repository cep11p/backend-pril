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
        
        /*********** SE OBTIENE COLECCION DE PERSONAS ********************/
        
        if(isset($params['global_param']) && !empty($params['global_param'])){
            $persona_params["global_param"] = $params['global_param'];
        }
        
        if(isset($params['localidadid']) && !empty($params['localidadid'])){
            $persona_params['localidadid'] = $params['localidadid'];
        }
        
        if(isset($params['calle']) && !empty($params['calle'])){
            $persona_params['calle'] = $params['calle'];    
        }

        $lista_personaid = array();
        $coleccion_persona = array();
        if (isset($persona_params)) {
            
            $coleccion_persona = $personaForm->buscarPersonaEnRegistral($persona_params);
            $lista_personaid = $this->obtenerListaIds($coleccion_persona);

            if (count($lista_personaid) < 1) {
                $query->where('0=1');
            }
        }
        

        /************ SE APLICAN LOS CRITERIOS EN EL FILTRADO ************/
        $query->from("area_entrenamiento as e");
        $query->andFilterWhere([
            'id' => $this->id,
            'planid' => $this->planid,
            'destinatarioid' => $this->destinatarioid,
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_final' => $this->fecha_final,
            'ofertaid' => $this->ofertaid,
        ]);

        $query->andFilterWhere(['like', 'e.tarea', $this->tarea])
              ->andFilterWhere(['like', 'e.descripcion_baja', $this->descripcion_baja]);
        
        if(count($lista_personaid)>0){
            $query->leftJoin("destinatario as d", "destinatarioid=d.id");            
            $query->andWhere(array('in', 'd.personaid', $lista_personaid));
        }
        
        /******************** FIN del filtrado por Persona ****************/
        
        /******* SE OBTIENE los Ambiente de trabajos filtrados como array******/
        $coleccion_area_entrenamiento = array();
        foreach ($dataProvider->getModels() as $value) {
            $area = $value->toArray();
            $area_entrenamiento['id'] = $area['id'];
            $area_entrenamiento['destinatarioid'] = $area['destinatarioid'];
            $area_entrenamiento['ofertaid'] = $area['ofertaid'];
            $area_entrenamiento['fecha_inicial'] = $area['fecha_inicial'];
            $area_entrenamiento['fecha_final'] = $area['fecha_final'];
            $area_entrenamiento['tarea'] = $area['tarea'];
            $area_entrenamiento['plan_nombre'] = $area['plan_nombre'];
            $area_entrenamiento['plan_monto'] = $area['plan_monto'];
            $area_entrenamiento['plan_hora_semanal'] = $area['plan_hora_semanal'];
            $area_entrenamiento['estado'] = $area['estado'];
            $coleccion_area_entrenamiento[] = $area_entrenamiento;
        }
        
        /************ Se vincunlan los destinatarios correspondiente a cada area de entrenamiento ****************/
        $coleccion_destintario = $this->obtenerDestintarioIdVinculado($coleccion_area_entrenamiento);
        $coleccion_area_entrenamiento = $this->vincularDestinatario($coleccion_area_entrenamiento, $coleccion_destintario);
        
        /************ Se vincunlan las ofertas correspondiente a cada area de entrenamiento ****************/
        $coleccion_oferta = $this->obtenerOfertaIdVinculada($coleccion_area_entrenamiento);
        $coleccion_area_entrenamiento = $this->vincularOferta($coleccion_area_entrenamiento, $coleccion_oferta);
        
        /*********** Se arma el array a mostrar **********/
        $data['total_filtrado']=$dataProvider->totalCount;
        $data['success']=(count($coleccion_area_entrenamiento)>0)?true:false;
        $data['resultado']=$coleccion_area_entrenamiento;
        
        return $data;
    }
    
    /**
     * Se vinculan los destinatarios a la lista de area de entrenamiento
     * @param array $coleccion_area_entrenamiento
     * @param array $coleccion_destinatario
     * @return array
     */
    private function vincularDestinatario($coleccion_area_entrenamiento = array(), $coleccion_destinatario = array()) {
        $i=0;
        foreach ($coleccion_area_entrenamiento as $area) {
            foreach ($coleccion_destinatario as $destinatario) {
                if(isset($area['destinatarioid']) && isset($destinatario['id']) && $area['destinatarioid']==$destinatario['id']){ 
                    
                    $area['destinatario']['id'] = $destinatario['id'];
                    $area['destinatario']['persona']['nro_documento'] = $destinatario['persona']['nro_documento'];
                    $area['destinatario']['persona']['nombre'] = $destinatario['persona']['nombre'];
                    $area['destinatario']['persona']['apellido'] = $destinatario['persona']['apellido'];
                    $coleccion_area_entrenamiento[$i] = $area;
                }
            }
            $i++;
        }
        
        return $coleccion_area_entrenamiento;
    }
    
    /**
     * Se vinculan las ofertas a la lista de area de entrenamiento
     * @param array $coleccion_area_entrenamiento
     * @param array $coleccion_oferta
     * @return array
     */
    private function vincularOferta($coleccion_area_entrenamiento = array(), $coleccion_oferta = array()) {
        $i=0;
        foreach ($coleccion_area_entrenamiento as $area) {
            foreach ($coleccion_oferta as $oferta) {
                if(isset($area['ofertaid']) && isset($oferta['id']) && $area['ofertaid']==$oferta['id']){ 

                    
                    $area['oferta']['id'] = $oferta['id'];
                    $area['oferta']['ambiente_trabajoid'] = $oferta['ambiente_trabajoid'];
                    $area['oferta']['ambiente_trabajo'] = $oferta['ambiente_trabajo'];
                    $area['oferta']['nombre_sucursal'] = $oferta['nombre_sucursal'];
                    $coleccion_area_entrenamiento[$i] = $area;
                }
            }
            $i++;
        }
        
        return $coleccion_area_entrenamiento;
    }
    
    /**
     * Se obtienen los ids de los destinatarios vinculados
     * @param array $coleccion_area_entrenamiento
     * @return array
     */
    private function obtenerDestintarioIdVinculado($coleccion_area_entrenamiento = array()) {
        $destinatario = new DestinatarioSearch();
        $ids='';
        foreach ($coleccion_area_entrenamiento as $area) {
            $ids .= (empty($ids))?$area['destinatarioid']:','.$area['destinatarioid'];
        }
        
        $coleccion_destintario = $destinatario->busquedadGeneral(array("ids"=>$ids));
        
        return $coleccion_destintario['resultado'];
    }
    
    /**
     * Se obtienen los ids de las ofertas vinculadas
     * @param array $coleccion_area_entrenamiento
     * @return array
     */
    private function obtenerOfertaIdVinculada($coleccion_area_entrenamiento = array()) {
        $oferta = new OfertaSearch();
        $ids='';
        foreach ($coleccion_area_entrenamiento as $area) {
            $ids .= (empty($ids))?$area['ofertaid']:','.$area['ofertaid'];
        }
        
        $coleccion_oferta = $oferta->busquedadGeneral(array("ids"=>$ids));
        
        return $coleccion_oferta['resultado'];
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