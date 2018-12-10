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
    "id": 1,
    "tarea": "una tarea",
    "planid": 1,
    "destinatarioid": 2,
    "fecha_inicial": "2018-12-12 09:12:12",
    "fecha_final": null,
    "descripcion_baja": null,
    "ofertaid": 1,
    "jornada": "una jornada",
    "observacion": "una observacion",
    "plan": "2000",
    "ambiente_trabajo": "Panaderia San Fernando",
    "destinatario": "Rodrigo Ezequiel",
    "destintario": {
        "id": 2,
        "oficioid": 1,
        "legajo": "usb123/7",
        "calificacion": 1,
        "profesionid": 1,
        "fecha_ingreso": "2018-12-10 15:28:36",
        "origen": "un origen fixture",
        "observacion": "1",
        "deseo_lugar_entrenamiento": "1",
        "deseo_actividad": "1",
        "fecha_presentacion": "2010-10-10",
        "personaid": 3,
        "banco_cbu": "1",
        "banco_nombre": "1",
        "banco_alias": "1",
        "experiencia_laboral": 1,
        "conocimientos_basicos": null,
        "profesion": "Abogado/a",
        "oficio": "Albañil"
    },
    "oferta": {
        "id": 1,
        "ambiente_trabajoid": 1,
        "nombre_sucursal": "Sucursal Nº 1",
        "puesto": "cajera",
        "area": "",
        "fecha_inicial": "2018-12-10 15:28:36",
        "fecha_final": null,
        "demanda_laboral": "falta una cajera",
        "objetivo": "conseguir personal especificamente para la caja",
        "lugarid": 1,
        "lugar": {
            "id": 1,
            "nombre": null,
            "calle": "Mitre",
            "altura": "327",
            "localidadid": 1,
            "latitud": "-123123",
            "longitud": "321123",
            "barrio": "Don Bosco",
            "piso": "Planta Baja",
            "depto": "A",
            "escalera": null,
            "localidad": "Capital Federal"
        },
        "ambiente_trabajo": "Panaderia San Fernando"
    }
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