<?php

namespace backend\modules\api\controllers;

use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\web\Controller;


class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
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
        $produtoMaisCaro = $produtosmodel::find()
            ->orderBy(['preco' => SORT_DESC])
            ->all(); // Mostra todos os resultados \ (one(); -> mostra só o 1 resultado)

        if ($produtoMaisCaro) {
            return $produtoMaisCaro;
        }

        return ['mensagem' => 'Nenhum produto encontrado.'];
    }
    public function actionPrecoBaixo()
    {
        $produtosmodel = new $this->modelClass;
        $produtoMaisBarato = $produtosmodel::find()
            ->orderBy(['preco' => SORT_ASC])
            ->all(); // Mostra todos os resultados \ (one(); -> mostra só o 1 resultado)

        if ($produtoMaisBarato) {
            return $produtoMaisBarato;
        }

        return ['mensagem' => 'Nenhum produto encontrado.'];
    }
}
