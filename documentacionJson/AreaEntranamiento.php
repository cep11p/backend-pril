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
    "tarea": "una tarea fixture",
    "planid": 1,
    "destinatarioid": 1,
    "fecha_inicial": "2018-12-12 00:00:00",
    "fecha_final": null,
    "descripcion_baja": null,
    "ofertaid": 4,
    "jornada": "una jornada",
    "observacion": "una observacion",
    "plan_nombre": "Plan A",
    "plan_monto": "2000",
    "plan_hora_semanal": "10hs",
    "destintario": {
        "id": 1,
        "oficioid": 1,
        "legajo": "usb123/6",
        "calificacion": 1,
        "profesionid": 1,
        "fecha_ingreso": "2018-12-18 13:43:28",
        "origen": "un origen fixture",
        "observacion": "1",
        "deseo_lugar_entrenamiento": "1",
        "deseo_actividad": "1",
        "fecha_presentacion": "2010-10-10",
        "personaid": 2,
        "banco_cbu": "1",
        "banco_nombre": "1",
        "banco_alias": "1",
        "experiencia_laboral": 1,
        "conocimientos_basicos": null,
        "profesion": "Abogado/a",
        "oficio": "Albañil",
        "persona": {
            "id": 2,
            "nombre": "Nahuel Ezequiel",
            "apellido": "Lopez",
            "nro_documento": "33890123",
            "fecha_nacimiento": "1984-12-12",
            "estado_civilid": 1,
            "telefono": "2920430124",
            "celular": "2920412124",
            "sexoid": 1,
            "tipo_documentoid": 1,
            "nucleoid": 1,
            "situacion_laboralid": 1,
            "generoid": null,
            "email": null,
            "cuil": "21338901237",
            "estudios": [
                {
                    "id": 1,
                    "titulo": "Titulo fixture 1",
                    "completo": 1,
                    "en_curso": 0,
                    "nivel_educativoid": 1,
                    "nivel_educativo": "Pre-Escolar",
                    "anio": "2001"
                },
                {
                    "id": 2,
                    "titulo": "Titulo fixture 2",
                    "completo": 1,
                    "en_curso": 0,
                    "nivel_educativoid": 2,
                    "nivel_educativo": "Primario",
                    "anio": "2001"
                }
            ],
            "sexo": "Hombre",
            "genero": "",
            "estado_civil": "Soltero/a",
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
                "entre_calle_1": null,
                "entre_calle_2": null,
                "localidad": "Capital Federal"
            }
        }
    },
    "oferta": {
        "id": 4,
        "ambiente_trabajoid": 2,
        "nombre_sucursal": "Sucursal Nº 1",
        "puesto": "Limipieza",
        "area": "",
        "fecha_inicial": "2018-12-11 15:26:12",
        "fecha_final": null,
        "demanda_laboral": "falta mantenimiento en la sucursal",
        "objetivo": "conseguir personal especificamente para limpieza",
        "lugarid": 3,
        "lugar": {
            "id": 3,
            "nombre": "Ministerio de Cultura",
            "calle": "Zatti",
            "altura": "123",
            "localidadid": 1,
            "latitud": "-123123",
            "longitud": "321123",
            "barrio": "Fatima",
            "piso": "3er piso",
            "depto": "",
            "escalera": null,
            "entre_calle_1": null,
            "entre_calle_2": null,
            "localidad": "Capital Federal"
        }
    },
    "ambiente_trabajo": {
        "nombre": "Panaderia Boomble",
        "cuit": "20123456789",
        "legajo": "asb123/1",
        "persona": {
            "nombre": "Nahuel Ezequiel",
            "apellido": "Lopez",
            "nro_documento": "33890123",
            "telefono": "2920430124",
            "celular": "2920412124",
            "email": null
        }
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