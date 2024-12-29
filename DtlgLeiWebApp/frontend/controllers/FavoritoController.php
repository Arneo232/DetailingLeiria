<?php

namespace frontend\controllers;

use common\models\Favorito;
use common\models\Profile;
use common\models\Produto;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * FavoritoController implements the CRUD actions for Favorito model.
 */
class FavoritoController extends Controller
{
    public function actionIndex(){
        $profileId = Yii::$app->user->identity->profile->idprofile;

        $favoritos = Favorito::find()
            ->where(['profile_id' => $profileId])
            ->with('produto')
            ->all();

        return $this->render('index', [
            'favoritos' => $favoritos,
        ]);
    }

    public function actionAdicionar($produto_id){
        $newFavorito = new Favorito();

        $profileID = Yii::$app->user->identity->profile->idprofile;

        $favorito = Favorito::find()->where(['profile_id' => $profileID, 'produto_id' => $produto_id])->one();

        if ($favorito) {
            if ($favorito->delete()){
                Yii::$app->session->setFlash('success', 'Produto removido dos favoritos com sucesso!');
            }
        }
        else {
            $newFavorito->profile_id = $profileID;
            $newFavorito->produto_id = $produto_id;
        }

        if($newFavorito->produto_id != null) {
            if ($newFavorito->save()) {
                Yii::$app->session->setFlash('success', 'Produto adicionado aos favoritos com sucesso!');
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao adicionar produto aos favoritos');
            }
        }
        return $this->redirect(['site/product']);
    }

    public function actionRemover($idfavorito)
    {
        $favorito = Favorito::findOne($idfavorito);

        if ($favorito && $favorito->profile_id == Yii::$app->user->identity->profile->idprofile) {
            $favorito->delete();
            Yii::$app->session->setFlash('success', 'Produto removido dos favoritos.');
        } else {
            Yii::$app->session->setFlash('error', 'Produto não encontrado ou acesso negado.');
        }

        return $this->redirect(['favorito/index']);
    }
}
