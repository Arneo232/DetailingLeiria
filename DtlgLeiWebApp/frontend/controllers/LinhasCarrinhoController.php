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
            return $this->redirect(['site/login']); // Redirect to login if the user is not logged in
        }

        $userId = Yii::$app->user->identity->profile->idprofile;

        // Fetch or create the user's cart
        $carrinho = Carrinho::find()->where(['idProfile' => $userId])->one();
        if (!$carrinho) {
            $carrinho = new Carrinho();
            $carrinho->idProfile = $userId;
            $carrinho->total = 0;
            $carrinho->save(false);
        }

        // Check if the product is already in the cart
        $linhaCarrinho = LinhasCarrinho::find()
            ->where(['carrinho_id' => $carrinho->idCarrinho, 'produtos_id' => $produto_id])
            ->one();

        if (!$linhaCarrinho) {
            // Add new product to the cart
            $linhaCarrinho = new LinhasCarrinho();
            $linhaCarrinho->carrinho_id = $carrinho->idCarrinho;
            $linhaCarrinho->produtos_id = $produto_id;
            $linhaCarrinho->quantidade = 1;
            $linhaCarrinho->precounitario = Produto::findOne($produto_id)->preco;
            $linhaCarrinho->subtotal = $linhaCarrinho->precounitario * $linhaCarrinho->quantidade;
        } else {
            // Update the quantity of the existing product
            $linhaCarrinho->quantidade += 1;
            $linhaCarrinho->subtotal = $linhaCarrinho->precounitario * $linhaCarrinho->quantidade;
        }

        $linhaCarrinho->save(false);

        // Update the cart total
        $carrinho->total = LinhasCarrinho::find()
            ->where(['carrinho_id' => $carrinho->idCarrinho])
            ->sum('subtotal');
        $carrinho->save(false);

        Yii::$app->session->setFlash('success', 'Product added to cart.');
        return $this->redirect(['carrinho/index']); // Redirect to the cart page
    }

    public function actionRemove($produto_id)
    {
        $linhaCarrinho = LinhasCarrinho::findOne($produto_id);
        if (!$linhaCarrinho) {
            throw new NotFoundHttpException('Item not found in cart.');
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

        // Update the cart total
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

            // Update the cart total
            $carrinho = $linhaCarrinho->carrinho;
            $carrinho->total = LinhasCarrinho::find()
                ->where(['carrinho_id' => $carrinho->idCarrinho])
                ->sum('subtotal');
            $carrinho->save(false);
        }

        return $this->redirect(['carrinho/index']);
    }

}
