<?php

namespace frontend\controllers;

use common\models\Linhasvenda;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinhasVendaController implements the CRUD actions for Linhasvenda model.
 */
class LinhasVendaController extends Controller
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
     * Lists all Linhasvenda models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Linhasvenda::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'idLinhasVenda' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Linhasvenda model.
     * @param int $idLinhasVenda Id Linhas Venda
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idLinhasVenda)
    {
        return $this->render('view', [
            'model' => $this->findModel($idLinhasVenda),
        ]);
    }

    /**
     * Creates a new Linhasvenda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Linhasvenda();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idLinhasVenda' => $model->idLinhasVenda]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Linhasvenda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idLinhasVenda Id Linhas Venda
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idLinhasVenda)
    {
        $model = $this->findModel($idLinhasVenda);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idLinhasVenda' => $model->idLinhasVenda]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Linhasvenda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idLinhasVenda Id Linhas Venda
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idLinhasVenda)
    {
        $this->findModel($idLinhasVenda)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Linhasvenda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idLinhasVenda Id Linhas Venda
     * @return Linhasvenda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idLinhasVenda)
    {
        if (($model = Linhasvenda::findOne(['idLinhasVenda' => $idLinhasVenda])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
