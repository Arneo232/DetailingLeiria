<?php

namespace backend\controllers;

use common\models\Categoria;
use common\models\Produto;
use common\models\Imagem;
use common\models\Desconto;
use backend\models\ImagemForm;
use backend\models\ProdutoSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
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
     * Lists all Produto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $categorias = Categoria::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categorias' => $categorias,
        ]);
    }
    /**
     * Displays a single Produto model.
     * @param int $idProduto Id Produto
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idProduto)
    {
        $imagem = $this->getImageAndPath($idProduto);
        $categorias = Categoria::find()->all();

        return $this->render('view', [
            'model' => $this->findModel($idProduto),
            'imagem' => $imagem,
            'categorias' => $categorias,
        ]);
    }

    /**
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produto();
        $imagem = new ImagemForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $this->uploadImage($model->idProduto, $imagem);
                return $this->redirect(['view', 'idProduto' => $model->idProduto]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'imagem' => $imagem,
        ]);
    }

    public function uploadImage($id, $imagem){
        if(Yii::$app->request->isPost){
            $imagem->imagens = UploadedFile::getInstances($imagem, 'imagens');
            if($imagem->saveImage($id)){
                return true;
            }
        }
        return false;
    }

    public function getImageAndPath($idProduto) {
        // Fetch the image object related to the product
        $imagem = Imagem::findOne(['produtoId' => $idProduto]);

        $imagem->fileName = Yii::getAlias('@backendUploads') . '/' . $imagem->fileName;

        return $imagem;
    }

    public function calcDesconto($preco, $idDesconto) {
        if($idDesconto == null) {
            return $preco;
        }

        $desconto = Desconto::findOne($idDesconto);

        $preco = $preco - ($preco * ($desconto->desconto / 100));

        return $preco;
    }

    public function actionDeleteImage($idimagem) {
        $imagem = Imagem::findOne($idimagem);

        if (!$imagem) {
            throw new \yii\web\NotFoundHttpException("The requested image does not exist.");
        }

        if ($imagem->deleteImage()) {
            Yii::$app->session->setFlash('success', 'Image deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete the image.');
        }

        return $this->redirect(['update', 'idProduto' => $imagem->produtoId]);
    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idProduto Id Produto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idProduto)
    {
        $model = $this->findModel($idProduto);
        $imagemProduto = Imagem::findAll(['produtoId' => $idProduto]) ?? null;

        if ($imagemProduto) {
            foreach ($imagemProduto as $img) {
                $img->fileName = Yii::getAlias('@backendUploads') . '/' . $img->fileName;
            }
        }

        $imagem = new ImagemForm();
        $model->preco = $this->calcDesconto($model->preco, $model->idDesconto);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $this->uploadImage($model->idProduto, $imagem);
            return $this->redirect(['view', 'idProduto' => $model->idProduto]);
        }

        return $this->render('update', [
            'model' => $model,
            'imagemProduto' => $imagemProduto,
            'imagem' => $imagem,
        ]);
    }

    /**
     * Deletes an existing Produto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idProduto Id Produto
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idProduto)
    {
        $images = Imagem::findAll(['produtoId' => $idProduto]);

        foreach ($images as $image) {
            $image->deleteImage(); // Delete associated images
        }

        $this->findModel($idProduto)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idProduto Id Produto
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idProduto)
    {
        if (($model = Produto::findOne(['idProduto' => $idProduto])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionProduct()
    {
        $searchModel = new ProdutoSearch();

        // Obtém os parâmetros da URL (keyword e categoria)
        $params = Yii::$app->request->queryParams;

        // Chama o método searchWithFilters e obtém o dataProvider com os filtros aplicados
        $dataProvider = $searchModel->searchWithFilters($params);

        // Passa o searchModel e o dataProvider para a view
        return $this->render('product', [
            'searchModel' => $searchModel,  // Passando o modelo de busca para a view
            'dataProvider' => $dataProvider,  // Passando o dataProvider para a view
        ]);
    }

}
