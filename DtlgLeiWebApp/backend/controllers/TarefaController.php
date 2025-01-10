<?php

namespace backend\controllers;

use common\models\Tarefa;
use backend\models\TarefaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TarefaController implements the CRUD actions for Tarefa model.
 */
class TarefaController extends Controller
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
     * Lists all Tarefa models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TarefaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tarefa model.
     * @param int $idTarefa Id Tarefa
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idTarefa)
    {
        return $this->render('view', [
            'model' => $this->findModel($idTarefa),
        ]);
    }

    /**
     * Creates a new Tarefa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tarefa();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idTarefa' => $model->idTarefa]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tarefa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idTarefa Id Tarefa
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idTarefa)
    {
        $model = $this->findModel($idTarefa);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idTarefa' => $model->idTarefa]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tarefa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idTarefa Id Tarefa
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idTarefa)
    {
        $this->findModel($idTarefa)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tarefa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idTarefa Id Tarefa
     * @return Tarefa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idTarefa)
    {
        if (($model = Tarefa::findOne(['idTarefa' => $idTarefa])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
