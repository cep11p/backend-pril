<?php



/****** Para mostrar listado ****
@url http://api.pril.local/api/ambiente-trabajo 
@method GET
{
    "total_filtrado":2,
    "total_general":123,
    "coleccion":{
        [
            {
                "id": 1,
                "nombre": "Panaderia San Fernando",
                "calificacion": 7,
                "personaid": 1,
                "legajo": "asb123/8",
                "observacion": "es una empresa que realiza actividades de panaderia y pasteleria",
                "cuit": "20123456789",
                "actividad": "Vende facturas, tortas y variedades de panes",
                "tipo_ambiente_trabajoid": 1,
                "lugarid": 1,
                "telefono1:"(2998) 123456789",
                "telefono2:"(2998) 123456789",
                "telefono3:"(2998) 123456789",
                "fax:"(2998) 123456789",
                "email:"mi_correo@correo.com",
                "persona": {
                    "id": 1,
                    "nombre": "Romina Belen",
                    "apellido": "Rodríguez",
                    "apodo": "rominochi",
                    "nro_documento": "29800100",
                    "fecha_nacimiento": "1980-12-12",
                    "estado_civilid": 1,
                    "telefono": "2920430690",
                    "celular": "2920412127",
                    "sexoid": 2,
                    "tipo_documentoid": 1,
                    "nucleoid": 1,
                    "situacion_laboralid": 1,
                    "generoid": 1,
                    "email": null,
                    "cuil": "21298001007",
                    "sexo": "Mujer",
                    "genero": "Masculino",
                    "estado_civil": "Soltero/a"
                },
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
            },
            {
                "id": 2,
                "nombre": "Panaderia San Fernando",
                "calificacion": 7,
                "personaid": 5,
                "legajo": "asb123/9",
                "observacion": "es una empresa que realiza actividades de panaderia y pasteleria",
                "cuit": "20123456789",
                "actividad": "Vende facturas, tortas y variedades de panes",
                "tipo_ambiente_trabajoid": 1,
                "lugarid": 9,
                 "telefono1:"(2998) 123456789",
                "telefono2:"(2998) 123456789",
                "telefono3:"(2998) 123456789",
                "fax:"(2998) 123456789",
                "email:"mi_correo@correo.com",
                "persona": {
                    "id": 5,
                    "nombre": "Diego",
                    "apellido": "Matinez",
                    "apodo": null,
                    "nro_documento": "27890098",
                    "fecha_nacimiento": "1980-12-12",
                    "estado_civilid": 1,
                    "telefono": "2920430690",
                    "celular": "2920412127",
                    "sexoid": 2,
                    "tipo_documentoid": 1,
                    "nucleoid": null,
                    "situacion_laboralid": 1,
                    "generoid": 1,
                    "email": "algo@correo.com.ar",
                    "cuil": "20367655678",
                    "sexo": "Mujer",
                    "genero": "Masculino",
                    "estado_civil": "Soltero/a"
                },
                "lugar": {
                    "id": 9,
                    "nombre": null,
                    "calle": "Mata Negra",
                    "altura": "1233",
                    "localidadid": 1,
                    "latitud": null,
                    "longitud": null,
                    "barrio": null,
                    "piso": null,
                    "depto": null,
                    "escalera": null,
                    "localidad": "Capital Federal"
                }
            }
        ]    
    }
}
**/

/****** Para crear****
Esta accion crea un ambiente de trabajo asociado con un lugarid, donde en el mismo se registran datos de georeferencia y geolocalizacion. 
@url http://api.pril.local/api/ambiente-trabajos
@method POST
{
    "nombre": "Panaderia San Fernando",
    "calificacion": 7,
    "legajo": "asb123/7",
    "observacion":"es una empresa que realiza actividades de panaderia y pasteleria",
    "cuit":"20123456789",
    "actividad": "Vende facturas, tortas y variedades de panes",
    "tipo_ambiente_trabajoid": 1,
    "telefono1:"(2998) 123456789",
    "telefono2:"(2998) 123456789",
    "telefono3:"(2998) 123456789",
    "fax:"(2998) 123456789",
    "email:"mi_correo@correo.com",
    "lugar": {
        "id": 1,
        "nombre": "",
        "calle": "Mitre",
        "altura": "327",
        "localidadid": 1,
        "latitud": "",
        "longitud": "",
        "barrio": "",
        "piso": "",
        "depto": "",
        "escalera": "",
    },
    "persona":{
        "nombre": "Diego",
        "apellido": "Matinez",
        "nro_documento": "27890098",
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
        "cuil":"20367655678"
    }	
}
**/

/**
**** Para modificar ****
@url http://api.pril.local/api/ambiente-trabajo/{$id} 
@method PUT
{
    "ambiente_trabajo":{
            "nombre": "Panaderia San Fernando",
            "calificacion": 7,
            "legajo": "asb123/7",
            "observacion":"es una empresa que realiza actividades de panaderia y pasteleria",
            "cuit":"20123456789",
            "actividad": "Vende facturas, tortas y variedades de panes",
            "tipo_ambiente_trabajoid": 1,
            "telefono1:"(2998) 123456789",
            "telefono2:"(2998) 123456789",
            "telefono3:"(2998) 123456789",
            "fax:"(2998) 123456789",
            "email:"mi_correo@correo.com",
    },
    "lugar": {
        "id": 1,
        "nombre": "",
        "calle": "Mitre",
        "altura": "327",
        "localidadid": 1,
        "latitud": "",
        "longitud": "",
        "barrio": "",
        "piso": "",
        "depto": "",
        "escalera": "",
    },
    "persona":{
        "nombre": "Diego",
        "apellido": "Matinez",
        "nro_documento": "27890098",
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
        "cuil":"20367655678"
    }		
}
**/

/****** Mostrado particular *******
@url http://api.pril.local/api/ambiente-trabajo/{$id} 
@method GET
@return 
{
    "id": 1,
    "nombre": "Panaderia San Fernando",
    "calificacion": 7,
    "personaid": 1,
    "legajo": "asb123/8",
    "observacion": "es una empresa que realiza actividades de panaderia y pasteleria",
    "cuit": "20123456789",
    "actividad": "Vende facturas, tortas y variedades de panes",
    "tipo_ambiente_trabajoid": 1,
    "lugarid": 1,
    "telefono1:"(2998) 123456789",
    "telefono2:"(2998) 123456789",
    "telefono3:"(2998) 123456789",
    "fax:"(2998) 123456789",
    "email:"mi_correo@correo.com",
    "persona": {
        "id": 1,
        "nombre": "Romina Belen",
        "apellido": "Rodríguez",
        "apodo": "rominochi",
        "nro_documento": "29800100",
        "fecha_nacimiento": "1980-12-12",
        "estado_civilid": 1,
        "telefono": "2920430690",
        "celular": "2920412127",
        "sexoid": 2,
        "tipo_documentoid": 1,
        "nucleoid": 1,
        "situacion_laboralid": 1,
        "generoid": 1,
        "email": null,
        "cuil": "21298001007",
        "sexo": "Mujer",
        "genero": "Masculino",
        "estado_civil": "Soltero/a"
    },
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
*/

/****** Para borrar *****
@url http://api.pril.local/api/ambiente-trabajo/{$id} 
@method Delete
@return arrayJson
{
	'success': TRUE,
	'msj': 'Se ha borrado un ambiente de trabajo'

}
*/