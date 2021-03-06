<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'PRIL',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'es',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '6zMHJ-tct8vLqga062EgpIylzJykgSFZ',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        
        'registral'=> [
            'class' => $params['servicioRegistral'],//'app\components\ServicioRegistral'
        ],
        
        'lugar'=> [
            'class' => $params['servicioLugar'],//'app\components\ServicioLugar'
        ],
        
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'es_ES',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
            
        ],
        
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
        'errorHandler' => [
            'errorAction' => 'site/error',
            'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
        ],
        
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/accion', 
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/plan', 
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/destinatario', 
//                    'extraPatterns' => [
//                        'GET buscarPersona/{id}' => 'mostrar',
//                        'GET buscar' => 'buscar',
//                        'OPTIONS buscaPersona' => 'options'
//                    ], 
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/ambiente-trabajo'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/area-entrenamiento'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/oferta'
                ],
                [   'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/persona', 
                    'extraPatterns' => [
                        'GET buscar-por-documento/{nro_documento}' => 'buscar-por-documento',
                        'OPTIONS buscar-por-documento/{nro_documento}' => 'buscar-por-documento',
                    ],                      
                    'tokens' => [ '{id}' => '<id:\\w+>', '{nro_documento}'=>'<nro_documento:\\w+>' ],
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/sexo'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/genero'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/estado-civil'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/localidad'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/nivel-educativo'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/oficio'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/profesion'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/tipo-ambiente-trabajo'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/role'
                ],
                [   
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/permiso'
                ],
            ],
        ],
        
    ],
    
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableConfirmation'=>false,
            'admins'=>['admin']
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
        
        "audit"=>[
            "class"=>"bedezign\yii2\audit\Audit",
            'accessIps'=>null,
            'accessUsers'=>null,
            'accessRoles'=>null
        ],
        
        'api' => [
            'class' => 'app\modules\api\Api',
        ],
        
        'backend' => [
            'class' => 'app\modules\backend\Backend',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment


    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
