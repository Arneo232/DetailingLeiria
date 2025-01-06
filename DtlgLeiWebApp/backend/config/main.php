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
                        'GET comperfil' => 'comperfil', // actionComperfil
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/auth',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',  // actionLogin
                        'POST register' => 'register'   // actionSignup
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/produto',
                    'extraPatterns' => [
                        'GET contagem' => 'contagem', // actionContagem
                        'GET precoalto' => 'precoalto', //actionPrecoAlto
                        'GET precobaixo' => 'precobaixo', //actionPrecoBaixo
                        'GET {idproduto}' => 'produto', //actionProduto
                        'GET todosprodutos' => 'todosprodutos', // actionTodosprodutos
                        'PUT {nomeproduto}' => 'putprecopornome', // actionPutprecopornome
                        'DELETE {nomeproduto}' => 'delpornome', // actionDelpornome
                    ],
                    'tokens' => [
                        '{idproduto}' => '<idproduto:\\d+>',
                        '{nomeproduto}' => '<nomeproduto:\\w+>', //[a-zA-Z0-9_] 1 ou + vezes (char)
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/carrinho',
                    'extraPatterns' => [
                        'GET {idprofile}' => 'carrinhoporid', // actionCarrinhoporid
                        'POST criarcarrinho' => 'criarcarrinho', // actionCriarcarrinho
                    ],
                    'tokens' => [
                        '{idprofile}' => '<idprofile:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/linhascarrinho',
                    'extraPatterns' => [
                        'POST addlinha' => 'addlinha', // actionAddlinha
                        'DELETE removerlinha' => 'removerlinha', // actionRemovelinha
                        'PUT aumentarlinha' => 'aumentarlinha', // actionAumentarlinha
                        'PUT diminuirlinha' => 'diminuirlinha', // actionDiminuirlinha
                        'GET linhasporidcarrinho' => 'linhasporidcarrinho', // actionLinhasporidcarrinho
                    ],
                    'tokens' => [
                        '{idlinha}' => '<idlinha:\\d+>',
                        '{idprofile}' => '<idprofile:\\d+>',
                        '{produto_id}' => '<produto_id:\\d+>',
                        '{idCarrinho}' => '<idCarrinho:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/venda',
                    'extraPatterns' => [
                        'POST finalizarcompra' => 'finalizarcompra', // actionFinalizarcompra
                        'GET vendasporperfil/{idprofilefk}' => 'vendasporperfil', // actionVendasporperfil
                        'GET linhasvendaporvenda/{idvenda}' => 'linhasvendaporvenda', // actionLinhasvendaporvenda
                    ],
                    'tokens' => [
                        '{idvenda}' => '<idvenda:\\d+>',
                        '{idprofilefk}' => '<idprofilefk:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/avaliacao',
                    'extraPatterns' => [
                        'POST fazeravaliacao/{idprodutofk}' => 'fazeravaliacao', // actionFazeravaliacao
                        'DELETE delavaliacaoporid/{idavaliacao}' => 'delavaliacaoporid', // actionDelavaliacaoporid
                        'GET avaliacoesporproduto/{idprodutofk}' => 'avaliacoesporproduto', // actionAvaliacoesporproduto
                    ],
                    'tokens' => [
                        '{idavaliacao}' => '<idavaliacao:\\d+>',
                        '{idprodutofk}' => '<idprodutofk:\\d+>',
                        '{idprofilefk}' => '<idprofilefk:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/favorito',
                    'extraPatterns' => [
                        'GET verificafav' => 'verificafav', // actionVerificafav
                        'POST addfav' =>'addfav', // actionAddfav
                        'DELETE {idfavorito}' => 'removefav', //actionRemovefav
                        'GET {profile_id}' => 'profilefav', //actionProfilefav
                    ],
                    'tokens' => [
                        '{produto_id}' => '<produto_id:\\d+>',
                        '{profile_id}' => '<profile_id:\\d+>',
                        '{idfavorito}' => '<idfavorito:\\d+>',
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
                        'GET designacoes' => 'designacoes', // actionDesignacao
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/desconto',
                    'extraPatterns' => [
                        'GET contagem' => 'contagem', // actionContagem
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/metodoentrega',
                    'extraPatterns' => [
                        'GET contagem' => 'contagem', // actionContagem
                        'DELETE delpornome/{nomeentrega}' => 'delpornome', // actionDelpornome
                        'PUT {nomeentrega}' => 'putpornome', // actionPornome
                        'POST novaentrega/{nomeentrega}' => 'novaentrega', // actionNovaentrega
                    ],
                    'tokens' => [
                        '{idmetodoentrega}' => '<id:\\d+>',
                        '{nomeentrega}' => '<nomeentrega:\\w+>', //[a-zA-Z0-9_] 1 ou + vezes (char)
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/metodoeagamento',
                    'extraPatterns' => [
                        'GET contagem' => 'contagem', // actionContagem
                    ],
                ]
            ],
        ],
    ],
    'params' => $params,
];

