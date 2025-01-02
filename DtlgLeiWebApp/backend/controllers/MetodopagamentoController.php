<?php

namespace backend\controllers;

use common\models\Metodopagamento;
use backend\models\MetodopagamentoSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii;

/**
 * MetodoPagamentoController implements the CRUD actions for Metodopagamento model.
 */
class MetodopagamentoController extends Controller
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
     * Lists all Metodopagamento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MetodopagamentoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Metodopagamento model.
     * @param int $idMetodoPagamento Id Metodo Pagamento
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idMetodoPagamento)
    {
        return $this->render('view', [
            'model' => $this->findModel($idMetodoPagamento),
        ]);
    }

    /**
     * Creates a new Metodopagamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Metodopagamento();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idMetodoPagamento' => $model->idMetodoPagamento]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Metodopagamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idMetodoPagamento Id Metodo Pagamento
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idMetodoPagamento)
    {
        $model = $this->findModel($idMetodoPagamento);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idMetodoPagamento' => $model->idMetodoPagamento]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Metodopagamento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idMetodoPagamento Id Metodo Pagamento
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idMetodoPagamento)
    {
        $this->findModel($idMetodoPagamento)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Metodopagamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idMetodoPagamento Id Metodo Pagamento
     * @return Metodopagamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idMetodoPagamento)
    {
        if (($model = Metodopagamento::findOne(['idMetodoPagamento' => $idMetodoPagamento])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
