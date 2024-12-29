<?php

namespace frontend\controllers;

use common\models\Carrinho;
use common\models\Metodoentrega;
use common\models\Metodopagamento;
use common\models\Linhascarrinho;
use common\models\Venda;
use common\models\Linhasvenda;
use common\models\Profile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;

/**
 * CarrinhoController implements the CRUD actions for Carrinho model.
 */
class CarrinhoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Carrinho models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->identity->profile->idprofile;

        $carrinho = Carrinho::findOne(['idProfile' => $userId]);

        if($carrinho === NULL) {
            if($this->CreateCarrinho($userId)) {
                $carrinho = Carrinho::findOne(['idProfile' => $userId]);
            }
        }

        $linhasCarrinho = Linhascarrinho::findAll(['carrinho_id' => $carrinho->idCarrinho]);

        return $this->render('index', [
            'carrinho' => $carrinho,
            'linhasCarrinho' => $linhasCarrinho,
        ]);
    }

    public function CreateCarrinho($userId) {
        $carrinho = new Carrinho();
        $carrinho->idProfile = $userId;
        $carrinho->datavenda = NULL;
        $carrinho->total = NULL;
        $carrinho->idMetodoPagamento = NULL;
        $carrinho->idMetodoEntrega = NULL;
        if($carrinho->save(false)) {
            return true;
        }
        return false;
    }

    public function actionCheckout()
    {
        $userId = Yii::$app->user->identity->profile->idprofile;
        $carrinho = Carrinho::findOne(['idProfile' => $userId]);
        $linhasCarrinho = Linhascarrinho::findAll(['carrinho_id' => $carrinho->idCarrinho]);

        $metodoEntrega = Metodoentrega::find()
            ->select(['designacao'])
            ->indexBy('idMetodoEntrega')
            ->column();

        $metodoPagamento = Metodopagamento::find()
            ->select(['designacao'])
            ->indexBy('idMetodoPagamento')
            ->column();

        return $this->render('checkout', [
            'carrinho' => $carrinho,
            'linhasCarrinho' => $linhasCarrinho,
            'metodoPagamento' => $metodoPagamento,
            'metodoEntrega' => $metodoEntrega,
        ]);
    }

    public function actionAdicionar($idCarrinho, $idProduto, $quantidade) {
        $carrinho = findModel($idCarrinho);
        $linha = new Linhascarrinho();
        $linha->carrinho_id = $idCarrinho;
        $linha->produtos_id = $idProduto;
        $linha->quantidade = $quantidade;

        return $this->redirect(['index']);
    }

    /**
     * Displays a single Carrinho model.
     * @param int $idCarrinho Id Carrinho
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idCarrinho)
    {
        return $this->render('view', [
            'model' => $this->findModel($idCarrinho),
        ]);
    }

    /**
     * Creates a new Carrinho model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Carrinho();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idCarrinho' => $model->idCarrinho]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Carrinho model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idCarrinho Id Carrinho
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idCarrinho)
    {
        $model = $this->findModel($idCarrinho);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idCarrinho' => $model->idCarrinho]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Carrinho model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idCarrinho Id Carrinho
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idCarrinho)
    {
        $this->findModel($idCarrinho)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Carrinho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idCarrinho Id Carrinho
     * @return Carrinho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idCarrinho)
    {
        if (($model = Carrinho::findOne(['idCarrinho' => $idCarrinho])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
