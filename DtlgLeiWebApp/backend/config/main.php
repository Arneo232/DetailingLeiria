<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/user',
                    'extraPatterns' => [
                        'GET contagem' => 'contagem', // actionContagem
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/fornecedor',
                    'extraPatterns' => [
                        'GET contagem' => 'contagem', // actionContagem
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/categoria',
                    'extraPatterns' => [
                        'GET contagem' => 'contagem', // actionContagem
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/produto',
                    'extraPatterns' => [
                        'GET contagem' => 'contagem', // actionContagem
                        'GET precoAlto' => 'preco-alto', //actionPrecoAlto
                        'GET precoBaixo' => 'preco-baixo', //actionPrecoBaixo
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/desconto',
                    'extraPatterns' => [
                        'GET contagem' => 'contagem', // actionContagem
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];

