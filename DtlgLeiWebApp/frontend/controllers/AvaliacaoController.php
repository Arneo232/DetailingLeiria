<?php

namespace frontend\controllers;

use yii;
use common\models\Linhasvenda;
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
    public function actionAddReview()
    {
        $idProduto = Yii::$app->request->post('idProduto');
        $idUser = Yii::$app->user->id;
        $comentario = Yii::$app->request->post('comentario');
        $rating = Yii::$app->request->post('rating');

        // Fetch the LinhasVenda record that corresponds to the product purchased by the user
        $linhasVenda = Linhasvenda::find()
            ->joinWith('venda') // Ensure this relation exists in the LinhasVenda model
            ->where([
                'linhasvenda.idProdutoFK' => $idProduto,
                'venda.idProfileFK' => $idUser,
            ])
            ->one();

        if (!$linhasVenda) {
            Yii::$app->session->setFlash('error', 'Você não pode avaliar este produto porque não o comprou.');
            return $this->redirect(['site/product-detail', 'idProduto' => $idProduto]);
        }

        // Create a new review and associate it with the LinhasVenda
        $avaliacao = new Avaliacao();
        $avaliacao->idLinhasVendaFK = $linhasVenda->idLinhasVenda;
        $avaliacao->comentario = $comentario;
        $avaliacao->rating = $rating;

        if ($avaliacao->save()) {
            Yii::$app->session->setFlash('success', 'Avaliação adicionada com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao salvar a avaliação.');
        }

        return $this->redirect(['site/product-detail', 'idProduto' => $idProduto]);
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
