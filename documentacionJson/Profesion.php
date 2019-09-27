**** Para mostrar listado ****
@url http://api.pril.local/api/profesion
@method GET
{
	[
	    {
		"id": 1,
		"nombre": "Abogado/a",
		"descripcion": null
	    },
	    {
		"id": 2,
		"nombre": "Académico/a",
		"descripcion": null
	    },
	    {
		"id": 3,
		"nombre": "Adjunto/a",
		"descripcion": null
	    },
	]
}

****Para crear un profesion ****
@url http://api.pril.local/api/profesion 
@method POST
@param arrayJson


**** Para modificar una profesion *****
@url http://api.pril.local/api/profesion/{$id} 
@method PUT
@param arrayJson
{
    "id": 1,
    "nombre": "Abogado/a",
    "descripcion": null
}


****** Para mostrar una profesion *****
@url http://api.pril.local/api/profesion/{$id} 
@method GET
@return arrayJson


****** Para borrar una profesion *****
@url http://api.pril.local/api/profesion/{$id} 
@method Delete
@return arrayJson

