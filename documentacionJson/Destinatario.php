<?php

/**
*** Para mostrar listado **** 
@url http://api.pril.local/api/destinatarios
@method GET
@return
{
    "total_filtrado":2,
    "total_general":123,
    "coleccion": [
    {
        "id": 1,
        "oficioid": 1,
        "legajo": "usb123/6",
        "calificacion": 1,
        "profesionid": 1,
        "fecha_ingreso": "2018-10-30 17:05:30",
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
            "apodo": null,
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
	    	"nivel_educativoid":4,
	    	"titulo":"tecnico en desarrollo web",
	    	"completo":1,
	    	"en_curso":0,
	    	"fecha"anio2014-12-20"
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
                "localidad": "Capital Federal"
            }
        }
    },
    {
        "id": 2,
        "oficioid": 1,
        "legajo": "usb123/6",
        "calificacion": 1,
        "profesionid": 1,
        "fecha_ingreso": "2018-10-30 17:05:30",
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
        "oficio": "Albañil",
        "persona": {
            "id": 3,
            "nombre": "Rodrigo Ezequiel",
            "apellido": "Rodríguez",
            "apodo": "rodri",
            "nro_documento": "29890123",
            "fecha_nacimiento": "1982-12-12",
            "estado_civilid": 1,
            "telefono": "2920430123",
            "celular": "2920412123",
            "sexoid": 1,
            "tipo_documentoid": 1,
            "nucleoid": 1,
            "situacion_laboralid": 1,
            "generoid": 1,
            "email": null,
            "cuil": "10298901238",
            "estudios": [
	    	{
	    	"nivel_educativoid":4,
	    	"titulo":"tecnico en desarrollo web",
	    	"completo":1,
	    	"en_curso":0,
	    	"anio":"2014-12-20"
	    	}
	    	{
	    	"nivel_educativoid":4,
	    	"titulo":"Otro estudio",
	    	"completo":1,
	    	"en_curso":0,
	    	"anio":"2014-12-20"
	    	}
            ],
            "sexo": "Hombre",
            "genero": "Masculino",
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
                "localidad": "Capital Federal"
            }
        }
    },
}
 
**/

/***** Para crear****
@url http://api.pril.local/api/destinatarios
@method POST
@param
{
	"destinatario":{
		"calificacion": 7,
		"legajo": "usb123/7",
		"profesionid":1,
		"oficioid": 2,
		"fecha_presentacion":"2000-12-12",
		"fecha_ingreso": "2000-12-12",
		"origen": "un origen",
		"deseo_lugar_entrenamiento": "Donde desea realizar el entrenamiento",
		"deseo_actividad": "La actividad que desea realizar",
		"experiencia_laboral": 1,
		"banco_cbu": "54321987654",
		"banco_nombre": "Patagonia",
		"banco_alias": "CAMION-RODILLO-RUEDA",
		"observacion": "Una observacion"
	},
	"persona":{
	    "nombre": "Romina",
	    "apellido": "Rodríguez",
	    "nro_documento": "29890098",
	    "fecha_nacimiento":"1980-12-12",
	    "apodo":"rominochi",
	    "telefono": "2920430690",
	    "celular": "2920412127",
	    "situacion_laboralid": 1,
	    "estado_civilid": 1,
	    "sexoid": 2,
	    "tipo_documentoid": 1,
	    "generoid": 1,
	    "email":"algo@correo.com.ar",
	    "cuil":"20367655678",
	    "estudios": [{
	    	"nivel_educativoid":4,
	    	"titulo":"tecnico en desarrollo web",
	    	"completo":1,
	    	"en_curso":0,
	    	"anio":"2014"
	    }],
	    "lugar": {
	    	"barrio":"Don bosco",
	    	"calle":"Mitre",
	    	"altura":"327",
	    	"piso":"A",
	    	"depto":"",
		"escalera":"",
	    	"localidadid":1,
	    	"latitud":"-123123",
		"longitud":"321123"
	    }

	}
		
}
 * 
 */


/**
 * **** Para modificar ****
@url http://api.pril.local/api/destinatarios/{$id} 
@method PUT
@param
{
    "success": true,
    "resultado": {
        "persona": {
            "id": 29,
            "nombre": "Alejandra",
            "apellido": "Rodríguez",
            "apodo": "rominochi",
            "nro_documento": "29890010",
            "fecha_nacimiento": "1980-12-12",
            "estado_civilid": 1,
            "telefono": "2920430690",
            "celular": "2920412127",
            "sexoid": 2,
            "tipo_documentoid": 1,
            "nucleoid": 17,
            "situacion_laboralid": 1,
            "generoid": 1,
            "email": "algo@correo.com.ar",
            "estudios": [
                {
                    "id": 31,
                    "titulo": "tecnico en desarrollo web",
                    "completo": 1,
                    "en_curso": 0,
                    "nivel_educativoid": 4
                },
                {
                    "id": 32,
                    "titulo": "nutricionista",
                    "completo": 1,
                    "en_curso": 0,
                    "nivel_educativoid": 4
                }
            ],
            "lugar": {
                "id": 23,
                "nombre": null,
                "calle": "saavedra",
                "altura": "327",
                "localidadid": 1,
                "latitud": "-123123",
                "longitud": "321123",
                "barrio": "Don bosco",
                "piso": "2",
                "depto": "",
                "escalera": ""
            }
        },
        "destinatario": {
            "id": 3,
            "oficioid": 2,
            "legajo": "usb123/7",
            "calificacion": 7,
            "profesionid": 1,
            "fecha_ingreso": "2018-09-26 00:00:00",
            "origen": "un origen",
            "observacion": "Una observacion",
            "deseo_lugar_entrenamiento": "Donde desea realizar el entrenamiento",
            "deseo_actividad": "La actividad que desea realizar",
            "fecha_presentacion": "2000-12-12",
            "personaid": 33,
            "banco_cbu": "54321987654",
            "banco_nombre": "Patagonia",
            "banco_alias": "CAMION-RODILLO-RUEDA",
            "experiencia_laboral": 1
        }
    }
}
*/

/******* Mostrado particular *******
@url http://api.pril.local/api/destinatarios/{$id} 
@method GET
@return 
{
    "id": 1,
    "oficioid": 1,
    "legajo": "usb123/6",
    "calificacion": 1,
    "profesionid": 1,
    "fecha_ingreso": "2018-10-30 17:05:30",
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
        "apodo": null,
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
        "estudios": [],
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
            "localidad": "Capital Federal"
        }
    }
}

****** Para borrar *****
@url http://api.pril.local/api/desinatarios/{$id} 
@method Delete
@return arrayJson
{
	'success': TRUE,
	'msj': 'Se ha borrado un Destinatario'

}
**/
