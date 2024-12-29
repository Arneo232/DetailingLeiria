<?php

namespace frontend\controllers;

use yii;
use common\models\Venda;
use common\models\Linhasvenda;
use common\models\Carrinho;
use common\models\Linhascarrinho;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;


/**
 * VendaController implements the CRUD actions for Venda model.
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

    /**
     * Lists all Venda models.
     *
     * @return string
     */

    public function actionFinalizarCompra()
    {
        $userId = Yii::$app->user->identity->profile->idprofile;

        $carrinho = Carrinho::find()->where(['idProfile' => $userId])->one();

        if (!$carrinho) {
            Yii::$app->session->setFlash('error', 'Nenhum carrinho encontrado.');
            return $this->redirect(['carrinho/index']);
        }

        $idMetodoEntrega = Yii::$app->request->post('idMetodoEntrega');
        $idMetodoPagamento = Yii::$app->request->post('idMetodoPagamento');

        if (!$idMetodoEntrega || !$idMetodoPagamento) {
            Yii::$app->session->setFlash('error', 'Por favor, selecione um método de entrega e pagamento.');
            return $this->redirect(['carrinho/checkout']);
        }

        $carrinho->idMetodoEntrega = $idMetodoEntrega;
        $carrinho->idMetodoPagamento = $idMetodoPagamento;

        if (!$carrinho->save(false)) {
            Yii::$app->session->setFlash('error', 'Erro ao salvar os detalhes do carrinho.');
            return $this->redirect(['carrinho/checkout']);
        }

        $venda = new Venda();
        $venda->idProfileFK = $userId;
        $venda->idCarrinhoFK = $carrinho->idCarrinho;
        $venda->total = $carrinho->total;
        $venda->datavenda = date('Y-m-d H:i:s');
        $venda->metodoPagamento_id = $carrinho->idMetodoPagamento;
        $venda->metodoEntrega_id = $carrinho->idMetodoEntrega;

        if (!$venda->save()) {
            Yii::$app->session->setFlash('error', 'Falha ao finalizar a compra.');
            return $this->redirect(['carrinho/index']);
        }

        $linhasCarrinho = LinhasCarrinho::findAll(['carrinho_id' => $carrinho->idCarrinho]);

        foreach ($linhasCarrinho as $linhaCarrinho) {
            $linhaVenda = new LinhasVenda();
            $linhaVenda->idVendaFK = $venda->idVenda;
            $linhaVenda->idProdutoFK = $linhaCarrinho->produtos_id;
            $linhaVenda->quantidade = $linhaCarrinho->quantidade;
            $linhaVenda->precounitario = $linhaCarrinho->precounitario;
            $linhaVenda->subtotal = $linhaCarrinho->subtotal;

            if (!$linhaVenda->save()) {
                Yii::$app->session->setFlash('error', 'Falha ao salvar as linhas da venda.');
                return $this->redirect(['carrinho/index']);
            }
        }

        LinhasCarrinho::deleteAll(['carrinho_id' => $carrinho->idCarrinho]);

        Yii::$app->session->setFlash('success', 'Compra efetuada com sucesso.');
        return $this->redirect(['venda/index', 'id' => $venda->idVenda]);
    }
    public function actionPdf($id)
    {
        $venda = Venda::findOne($id);
        if (!$venda) {
            Yii::$app->session->setFlash('error', 'Venda não encontrada.');
            return $this->redirect(['venda/index']);
        }

        $linhasVenda = $venda->getLinhasVenda()->all();
        $content = $this->renderPartial('_fatura', [
            'venda' => $venda,
            'linhasVenda' => $linhasVenda,
        ]);


        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);

        $pdfFileName = "Fatura{$venda->idVenda}.pdf";
        return $mpdf->Output($pdfFileName, \Mpdf\Output\Destination::DOWNLOAD);
    }


    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Venda::find(),
        ]);

        $vendas = Venda::find()->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'vendas' => $vendas,
        ]);
    }

    public function actionDetailVenda($id)
    {
        $venda = Venda::findOne($id);

        if (!$venda) {
            throw new NotFoundHttpException('Venda not found.');
        }

        // Fetch LinhasVenda related to this Venda
        $linhasVenda = LinhasVenda::find()->where(['idVendaFK' => $id])->all();

        return $this->render('detailVenda', [
            'venda' => $venda,
            'linhasVenda' => $linhasVenda,
        ]);
    }

    /**
     * Displays a single Venda model.
     * @param int $idVenda
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idVenda)
    {
        return $this->render('view', [
            'model' => $this->findModel($idVenda),
        ]);
    }

    /**
     * Creates a new Venda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Venda();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idVenda' => $model->idVenda]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Venda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idVenda
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idVenda)
    {
        $model = $this->findModel($idVenda);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idVenda' => $model->idVenda]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Venda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idVenda
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idVenda)
    {
        $this->findModel($idVenda)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Venda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idVenda
     * @return Venda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idVenda)
    {
        if (($model = Venda::findOne(['idVenda' => $idVenda])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
