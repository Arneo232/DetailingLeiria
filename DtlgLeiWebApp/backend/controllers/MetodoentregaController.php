<?php

namespace backend\controllers;

use common\models\Metodoentrega;
use backend\models\metodoEntregaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MetodoEntregaController implements the CRUD actions for Metodoentrega model.
 */
class MetodoentregaController extends Controller
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
     * Lists all Metodoentrega models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new metodoEntregaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Metodoentrega model.
     * @param int $idmetodoEntrega Idmetodo Entrega
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idmetodoEntrega)
    {
        return $this->render('view', [
            'model' => $this->findModel($idmetodoEntrega),
        ]);
    }

    /**
     * Creates a new Metodoentrega model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Metodoentrega();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idmetodoEntrega' => $model->idmetodoEntrega]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Metodoentrega model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idmetodoEntrega Idmetodo Entrega
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idmetodoEntrega)
    {
        $model = $this->findModel($idmetodoEntrega);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idmetodoEntrega' => $model->idmetodoEntrega]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Metodoentrega model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idmetodoEntrega Idmetodo Entrega
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idmetodoEntrega)
    {
        $this->findModel($idmetodoEntrega)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Metodoentrega model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idmetodoEntrega Idmetodo Entrega
     * @return Metodoentrega the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idmetodoEntrega)
    {
        if (($model = Metodoentrega::findOne(['idmetodoEntrega' => $idmetodoEntrega])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
