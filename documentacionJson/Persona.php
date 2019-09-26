<?php

/**** obtener lista de Personas ***
@url ejemplo http://pril.local/api/personas?nombre=lorena&nro_documento=36849868
@Method GET

{
    
}
**/

/**** obtener Persona por nro_documento ***
@url ejemplo http://pril.local/api/personas/buscar-por-documento/29800100
@Method GET
{
    "success": true,
    "resultado": [
        {
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
            ...,
        }
    ]
}
**/