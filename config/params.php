<?php

$params = [
    'adminEmail' => 'admin@example.com',
    'URL_REGISTRAL' => 'http://registral',
    'USUARIO_REGISTRAL'=>'pril',
    'JWT_SECRET' => '123456',
    'JWT_REGISTRAL' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c3VhcmlvIjoicHJpbCIsInVpZCI6M30.5d__tzC3H4BdVXHaRPCKX2zjtdFScR6jI4mCKsw8QhQ',
    'JWT_LUGAR' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c3VhcmlvIjoiYWRtaW4iLCJ1aWQiOjF9.rTItKCAU2xYxW1kiCDwP-e64LK2DG6PAq7FGCs43V5s',
    'JWT_EXPIRE' => 10*24*60*60,
    'servicioRegistral'=> getenv('SERVICIO_REGISTRAL')?getenv('SERVICIO_REGISTRAL'):'app\components\DummyServicioRegistral',
    'servicioLugar'=> getenv('SERVICIO_LUGAR')?getenv('SERVICIO_LUGAR'):'app\components\DummyServicioLugar'
];

return $params;
