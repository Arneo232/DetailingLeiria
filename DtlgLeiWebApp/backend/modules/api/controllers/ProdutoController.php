<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\User;
use yii\filters\ContentNegotiator;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\Imagem;
use yii\web\Controller;
use Yii;

class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';
    public $user = null;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function authCustom($token)
    {
        $user_ = User::findIdentityByAccessToken($token);
        if ($user_) {
            $this->user = $user_;
            return $user_;
        }
        throw new ForbiddenHttpException('No authentication'); //403
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if (isset(Yii::$app->params['id']) && Yii::$app->params['id'] == 1) {
            if ($action === "delete") {
                throw new \yii\web\ForbiddenHttpException('Proibido');
            }
        }
    }

    public function actionContagem()
    {
        $produtosmodel = new $this->modelClass;
        $produtocontador = $produtosmodel::find()->all();
        return ['contagem' => count($produtocontador)];
    }

    public function actionPrecoAlto()
    {
        $produtosmodel = new $this->modelClass;
        $produtoMaisCaro = $produtosmodel::find()->orderBy(['preco' => SORT_DESC])->all();

        if ($produtoMaisCaro) {
            return $produtoMaisCaro;
        }
        return ['mensagem' => 'Nenhum produto encontrado.'];
    }

    public function actionPrecoBaixo()
    {
        $produtosmodel = new $this->modelClass;
        $produtoMaisBarato = $produtosmodel::find()->orderBy(['preco' => SORT_ASC])->all();

        if ($produtoMaisBarato) {
            return $produtoMaisBarato;
        }
        return ['mensagem' => 'Nenhum produto encontrado.'];
    }

    public function actionProduto($idproduto)
    {
        $produtosmodel = new $this->modelClass;

        // Fetch the product by ID
        $produto = $produtosmodel::find()->where(['idproduto' => $idproduto])->one();

        if (!$produto) {
            return [
                'success' => false,
                'message' => 'Produto não foi encontrado.'
            ];
        }

        $imagem = Imagem::find()->where(['produtoId' => $produto->idProduto])->all();

        $data = [
            'produto' => $produto,
            'imagens' => $imagem
        ];

        return [
            'success' => true,
            'message' => 'Produto encontrado com sucesso.',
            'data' => $data
        ];
    }

    public function actionTodosprodutos()
    {
        $produtosmodel = new $this->modelClass;

        $produtos = $produtosmodel::find()->all();

        if (!$produtos) {
            return [
                'success' => false,
                'message' => 'Produtos não encontrados.'
            ];
        }

        $data = [];

        foreach ($produtos as $produto) {
            $imagens = Imagem::find()->where(['produtoId' => $produto->idProduto])->all();

            $data[] = [
                'produto' => $produto,
                'imagens' => $imagens
            ];
        }

        return [
            'success' => true,
            'message' => 'Produtos encontrados com sucesso.',
            'data' => $data
        ];
    }

    public function actionDelpornome($nomeproduto)
    {
        $produtosmodel = new $this->modelClass;

        $produto = $produtosmodel::findOne(['nome' => $nomeproduto]);

        Imagem::deleteAll(['produtoId' => $produto->idProduto]);

        $deletedCount = $produto->delete();

        return ['deletedCount' => $deletedCount];
    }

    public function actionPutprecopornome($nomeproduto)
    {
        $novo_preco = \Yii::$app->request->post('preco');
        $produtosmodel = new $this->modelClass;
        $ret = $produtosmodel::findOne(['nome' => $nomeproduto]);
        if ($ret) {
            $ret->preco = $novo_preco;
            $ret->save();
            throw new \yii\web\NotFoundHttpException("Preço do produto alterado com sucesso para: " . $novo_preco . "€");
        } else {
            throw new \yii\web\NotFoundHttpException("Nome de produto não existe.");
        }
    }
}
