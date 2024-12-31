<?php

namespace frontend\controllers;

use yii;
use yii\helpers\ArrayHelper;
use common\models\Linhasvenda;
use common\models\Venda;
use common\models\Produto;
use common\models\avaliacao;
use frontend\models\AvaliacaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AvaliacaoController implements the CRUD actions for avaliacao model.
 */
class AvaliacaoController extends Controller
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
     * Lists all avaliacao models.
     *
     * @return string
     */

    public function actionFazerAvaliacao($idProduto)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Para deixar uma avaliação, é necessário estar logado.');
            return $this->redirect(['site/login']);
        }

        $product = Produto::findOne($idProduto);
        if (!$product) {
            Yii::$app->session->setFlash('error', 'Produto não encontrado.');
            return $this->redirect(['site/product']);
        }

        $profileId = Yii::$app->user->identity->profile->idprofile;

        $vendas = Venda::find()->where(['idProfileFK' => $profileId])->all();

        $idsVenda = ArrayHelper::getColumn($vendas, 'idVenda');

        $linhasVenda = LinhasVenda::find()->where(['idVendaFK' => $idsVenda])->all();

        $productId = ArrayHelper::getColumn($linhasVenda, 'idProdutoFK');

        if (!in_array($idProduto, $productId)) {
            Yii::$app->session->setFlash('error', 'É necessário comprar este produto para poder deixar uma avaliação.');
            return $this->redirect(['site/product-detail', 'idProduto' => $idProduto]);
        }

        $reviewModel = new Avaliacao();

        $reviewModel->idProfileFK = $profileId;
        $reviewModel->idProdutoFK = $idProduto;

        if ($reviewModel->load(Yii::$app->request->post()) && $reviewModel->validate()) {
            $reviewModel->idProfileFK = $profileId;
            $reviewModel->idProdutoFK = $idProduto;
            if ($reviewModel->save()) {
                Yii::$app->session->setFlash('success', 'A sua avaliação foi submetida com sucesso!');
                return $this->redirect(['site/product-detail', 'idProduto' => $idProduto]);
            } else {
                Yii::$app->session->setFlash('error', 'Houve um erro ao submeter a avaliação.');
            }
        }else{
            Yii::$app->session->setFlash('error', 'Houve um erro na validação da sua avaliação.');
        }

        return $this->render('//site/product-detail', [
            'product' => $product,
            'avaliacoes' => Avaliacao::find()->where(['idProdutoFK' => $idProduto])->all(),
            'reviewModel' => $reviewModel, // Pass the invalid model back to the view
        ]);
    }


    public function actionRemoverAvaliacao($idavaliacao)
    {
        $review = Avaliacao::findOne($idavaliacao);
        if (!$review) {
            Yii::$app->session->setFlash('error', 'A avaliação não existe.');
            return $this->redirect(['site/product-detail', 'idProduto' => Yii::$app->request->get('idProduto')]);
        }

        if (Yii::$app->user->identity->id != $review->profile->user->id) {
            Yii::$app->session->setFlash('error', 'Não pode apagar esta avaliação.');
            return $this->redirect(['site/product-detail', 'idProduto' => Yii::$app->request->get('idProduto')]);
        }

        if ($review->delete()) {
            Yii::$app->session->setFlash('success', 'Sua avaliação foi apagada.');
        } else {
            Yii::$app->session->setFlash('error', 'Houve um erro ao tentar apagar a avaliação.');
        }
        return $this->redirect(['site/product-detail', 'idProduto' => Yii::$app->request->get('idProduto')]);
    }

    public function actionIndex()
    {
        $searchModel = new AvaliacaoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single avaliacao model.
     * @param int $idavaliacao Idavaliacao
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idavaliacao)
    {
        return $this->render('view', [
            'model' => $this->findModel($idavaliacao),
        ]);
    }

    /**
     * Creates a new avaliacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new avaliacao();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idavaliacao' => $model->idavaliacao]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing avaliacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idavaliacao Idavaliacao
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idavaliacao)
    {
        $model = $this->findModel($idavaliacao);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idavaliacao' => $model->idavaliacao]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing avaliacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idavaliacao Idavaliacao
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idavaliacao)
    {
        $this->findModel($idavaliacao)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the avaliacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idavaliacao Idavaliacao
     * @return avaliacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idavaliacao)
    {
        if (($model = avaliacao::findOne(['idavaliacao' => $idavaliacao])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
