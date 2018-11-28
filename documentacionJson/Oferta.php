<?php

/**** Para mostrar listado ****
@url http://api.pril.local/api/oferta
@method GET
{
	"total_filtrado":2,
	"total_general":123,
	"coleccion":{
		[
			{
		      		"id": 2,
			        "ambiente_trabajoid": 1,
                                "ambiente_trabajo":"Panaderia San Fernando",
			        "nombre_sucursal": "Sucursal 1 - Paderia Mitre",
			        "puesto": "cajera",
			        "area":"",
			        "fecha_inicial": 01/07/2018,
			        "fecha_final": "",
			        "demanda_laboral": "Falta dividir responsabilidades",
			        "objetivo": "Poder dar una oportunidad de trabajo",
			        "dia_horario": "lunes a viernes 10 a 12:30",
			        "lugarid": 2,
			        "tarea": "tareas de cajera",
		
			},
			{
				"id": 3,
				"ambiente_trabajoid": 1,
                                "ambiente_trabajo":"Panaderia San Fernando",
				"nombre_sucursal": "Sucursal 2 - Peatonal Buenos Aires",
				"puesto": "cajera",
				"area":"",
				"fecha_inicial": 02/06/2018,
				"fecha_final": "",
				"demanda_laboral": "Falta dividir responsabilidades",
				"objetivo": "Poder dar una oportunidad de trabajo",
				"dia_horario": "lunes a viernes 10 a 12:30",
				"lugarid": 3,
				"tarea": "tareas de cajera",
		
			}
		]    
	}
}
*/


/****Para crear un Oferta ****
@url http://api.pril.local/api/oferta 
@method POST
@param arrayJson
{
    "ambiente_trabajoid": 1,
    "nombre_sucursal": "Sucursal 1 - Paderia Mitre",
    "puesto": "cajera",
    "area":"",
    "fecha_inicial": 2018-12-12,
    "fecha_final": "",
    "demanda_laboral": "Falta dividir responsabilidades",
    "objetivo": "Poder dar una oportunidad de trabajo",
    "dia_horario": "lunes a viernes 10 a 12:30",
    "lugarid": 2,
    "tarea": "tareas de cajera",
		
}
 * 
 */


/**** Para modificar una oferta *****
@url http://api.pril.local/api/oferta/{$id} 
@method PUT
@param arrayJson
{
	    "id": 2,
	    "ambiente_trabajoid": 1,
	    "nombre_sucursal": "Sucursal 1 - Paderia Mitre",
	    "puesto": "cajera",
	    "area":"",
	    "fecha_inicial": 2018-12-12,
	    "fecha_final": "",
	    "demanda_laboral": "Falta dividir responsabilidades",
	    "objetivo": "Poder dar una oportunidad de trabajo",
	    "dia_horario": "lunes a viernes 10 a 12:30",
	    "lugarid": 2,
	    "tarea": "tareas de cajera",
		
}
 * 
 */


/**
****** Para mostrar una Oferta *****
@url http://api.pril.local/api/oferta/{$id} 
@method GET
@return arrayJson
{
	    "id": 2,
	    "ambiente_trabajo":"Panaderia San Fernando",
	    "nombre_sucursal": "Sucursal 1 - Paderia Mitre",
	    "puesto": "cajera",
	    "area":"",
	    "fecha_inicial": 12/12/2018,
	    "fecha_final": "",
	    "demanda_laboral": "Falta dividir responsabilidades",
	    "objetivo": "Poder dar una oportunidad de trabajo",
	    "dia_horario": "lunes a viernes 10 a 12:30",
	    "lugarid": {
		"direccion": "mitre y rivadavia"
	    },
	    "tarea": "tareas de cajera",
}
 * 
 */

/**
****** Para borrar una oferta *****
@url http://api.pril.local/api/oferta/{$id} 
@method Delete
@return arrayJson
{
	'success': TRUE,
	'msj': 'Se ha borrado un ambiente de trabajo'

}*/
