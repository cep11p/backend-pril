<?php



/****** Para mostrar listado ****
@url http://api.pril.local/api/area-entrenamientos
@method GET
{
}
**/

/****** Para crear****
Esta accion crea un area de entrenamiento
@url http://api.pril.local/api/area-entrenamientos
@method POST
{
	"tarea":"una tarea",
	"planid":1,
	"ofertaid":1,
	"destinatarioid":2,
	"fecha_inicial":"2018-12-12",
	"observacion":"una observacion",
	"jornada":"una jornada"
}
**/

/**
**** Para modificar ****
@url http://api.pril.local/api/area-entrenamientos/{$id} 
@method PUT
{	
}
**/

/****** Mostrado particular *******
@url http://api.pril.local/api/area-entrenamientos/{$id} 
@method GET
@return 
{
    "id": 12,
    "tarea": "una tarea",
    "planid": 1,
    "destinatarioid": 2,
    "fecha_inicial": "2018-12-12 00:00:00",
    "fecha_final": null,
    "descripcion_baja": null,
    "ofertaid": 1,
    "jornada": "una jornada",
    "observacion": "una observacion",
    "plan": "2000",
    "ambiente_trabajo": "Panaderia San Fernando",
    "destinatario": "Pilar"
}
*/

/****** Para borrar *****
@url http://api.pril.local/api/area-entrenamiento/{$id} 
@method Delete
@return arrayJson
{
	'success': TRUE,
	'msj': 'Se ha borrado un ambiente de trabajo'

}
*/