<?php

namespace backend\controllers;

use common\models\Desconto;
use backend\models\DescontoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DescontoController implements the CRUD actions for Desconto model.
 */
class DescontoController extends Controller
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
     * Lists all Desconto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DescontoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Desconto model.
     * @param int $iddesconto Iddesconto
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($iddesconto)
    {
        return $this->render('view', [
            'model' => $this->findModel($iddesconto),
        ]);
    }

    /**
     * Creates a new Desconto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Desconto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'iddesconto' => $model->iddesconto]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Desconto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $iddesconto Iddesconto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($iddesconto)
    {
        $model = $this->findModel($iddesconto);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'iddesconto' => $model->iddesconto]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Desconto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $iddesconto Iddesconto
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($iddesconto)
    {
        $this->findModel($iddesconto)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Desconto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $iddesconto Iddesconto
     * @return Desconto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($iddesconto)
    {
        if (($model = Desconto::findOne(['iddesconto' => $iddesconto])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
