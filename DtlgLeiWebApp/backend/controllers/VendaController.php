<?php

namespace backend\controllers;

use common\models\venda;
use backend\models\VendaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * VendaController implements the CRUD actions for venda model.
 */
class VendaController extends Controller
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

    public function actionToggleEstadoEncomenda($idVenda)
    {
        $model = Venda::findOne($idVenda);

        if ($model) {
            $model->estado_encomenda = !$model->estado_encomenda;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Estado da encomenda atualizado com sucesso.');
            } else {
                Yii::$app->session->setFlash('error', 'Falha ao atualizar o estado da encomenda.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Venda não encontrada.');
        }

        return $this->redirect(['index']);
    }

    public function actionNaoEntregue()
    {
        $searchModel = new VendaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['estado_encomenda' => 0]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEntregue()
    {
        $searchModel = new VendaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['estado_encomenda' => 1]);

        return $this->render('encomendaFeita', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all venda models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VendaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single venda model.
     * @param int $idVenda
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionView($idVenda)
    {
        $model = $this->findModel($idVenda);

        $linhasVenda = $model->getLinhasVenda()->with('produto')->all();

        // Passar as linhas de venda para a visualização
        return $this->render('view', [
            'model' => $model,
            'linhasVenda' => $linhasVenda,
        ]);
    }


    /**
     * Creates a new venda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */


    /**
     * Updates an existing venda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idVenda
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */


    /**
     * Deletes an existing venda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idVenda
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Finds the venda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idVenda
     * @return venda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idVenda)
    {
        if (($model = venda::findOne(['idVenda' => $idVenda])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
