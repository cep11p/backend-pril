<?php

$params = [
    'adminEmail' => 'admin@example.com',
    'URL_REGISTRAL' => 'http://registral',
    'USUARIO_REGISTRAL'=>'pril',
    'JWT_SECRET' => '123456',
    'JWT_REGISTRAL' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1NjgxMzQzMjksInVzdWFyaW8iOiJwcmlsIiwidWlkIjozfQ.7JXTMw8JMj19a-BSd7sKB5gRAjsbiDHoF6sVWPGghps',
    'JWT_LUGAR' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c3VhcmlvIjoiYWRtaW4iLCJ1aWQiOjF9.rTItKCAU2xYxW1kiCDwP-e64LK2DG6PAq7FGCs43V5s',
    'JWT_EXPIRE' => 10*24*60*60,
    'servicioRegistral'=> getenv('SERVICIO_REGISTRAL')?getenv('SERVICIO_REGISTRAL'):'app\components\DummyServicioRegistral',
    'servicioLugar'=> getenv('SERVICIO_LUGAR')?getenv('SERVICIO_LUGAR'):'app\components\DummyServicioLugar'
];

return $params;
