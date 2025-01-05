<?php

namespace frontend\controllers;

use common\models\Linhascarrinho;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Produto;
use common\models\Carrinho;
use yii;

/**
 * LinhasCarrinhoController implements the CRUD actions for Linhascarrinho model.
 */
class LinhasCarrinhoController extends Controller
{
    public function actionAdicionar($produto_id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $userId = Yii::$app->user->identity->profile->idprofile;

        $carrinho = Carrinho::find()->where(['idProfile' => $userId])->one();
        if (!$carrinho) {
            $carrinho = new Carrinho();
            $carrinho->idProfile = $userId;
            $carrinho->total = 0;
            $carrinho->save(false);
        }

        $linhaCarrinho = LinhasCarrinho::find()
            ->where(['carrinho_id' => $carrinho->idCarrinho, 'produtos_id' => $produto_id])
            ->one();

        if (!$linhaCarrinho) {
            $linhaCarrinho = new LinhasCarrinho();
            $linhaCarrinho->carrinho_id = $carrinho->idCarrinho;
            $linhaCarrinho->produtos_id = $produto_id;
            $linhaCarrinho->quantidade = 1;
            $linhaCarrinho->precounitario = Produto::findOne($produto_id)->preco;
            $linhaCarrinho->subtotal = $linhaCarrinho->precounitario * $linhaCarrinho->quantidade;
        } else {
            $linhaCarrinho->quantidade += 1;
            $linhaCarrinho->subtotal = $linhaCarrinho->precounitario * $linhaCarrinho->quantidade;
        }

        $linhaCarrinho->save(false);

        $carrinho->total = LinhasCarrinho::find()->where(['carrinho_id' => $carrinho->idCarrinho])->sum('subtotal');
        $carrinho->save(false);

        Yii::$app->session->setFlash('success', 'Produto adicionado ao carrinho.');
        return $this->redirect(['carrinho/index']);
    }

    public function actionRemover($produto_id)
    {
        $linhaCarrinho = LinhasCarrinho::findOne($produto_id);
        if (!$linhaCarrinho) {
            throw new NotFoundHttpException('Produto não encontrado no carrinho.');
        }

        $carrinho = $linhaCarrinho->carrinho;
        $carrinho->total -= $linhaCarrinho->subtotal;
        $linhaCarrinho->delete();
        $carrinho->save(false);

        return $this->redirect(['carrinho/index']);
    }

    public function actionAumentar($id)
    {
        $linhaCarrinho = LinhasCarrinho::findOne($id);
        if (!$linhaCarrinho) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        $linhaCarrinho->quantidade += 1;
        $linhaCarrinho->subtotal = $linhaCarrinho->quantidade * $linhaCarrinho->precounitario;
        $linhaCarrinho->save(false);

        $carrinho = $linhaCarrinho->carrinho;
        $carrinho->total = LinhasCarrinho::find()
            ->where(['carrinho_id' => $carrinho->idCarrinho])
            ->sum('subtotal');
        $carrinho->save(false);

        return $this->redirect(['carrinho/index']);
    }

    public function actionRetirar($id)
    {
        $linhaCarrinho = LinhasCarrinho::findOne($id);
        if (!$linhaCarrinho) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        if ($linhaCarrinho->quantidade > 1) {
            $linhaCarrinho->quantidade -= 1;
            $linhaCarrinho->subtotal = $linhaCarrinho->quantidade * $linhaCarrinho->precounitario;
            $linhaCarrinho->save(false);

            $carrinho = $linhaCarrinho->carrinho;
            $carrinho->total = LinhasCarrinho::find()
                ->where(['carrinho_id' => $carrinho->idCarrinho])
                ->sum('subtotal');
            $carrinho->save(false);
        }
        return $this->redirect(['carrinho/index']);
    }
}
