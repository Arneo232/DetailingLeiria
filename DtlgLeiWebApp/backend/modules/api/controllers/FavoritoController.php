<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\User;
use backend\modules\api\components\CustomAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\web\Controller;
use common\models\Favorito;
use yii\web\ForbiddenHttpException;

class FavoritoController extends ActiveController
{
    public $modelClass = 'common\models\Favorito';

    public $user = null;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function authCustom($token)
    {
        $user_ = User::findIdentityByAccessToken($token);
        if ($user_) {
            $this->user = $user_;
            return $user_;
        }
        throw new ForbiddenHttpException('No authentication'); //403
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if (isset(Yii::$app->params['id']) && Yii::$app->params['id'] == 1) {
            if ($action === "delete") {
                throw new \yii\web\ForbiddenHttpException('Proibido');
            }
        }
    }

    public function actionVerificafav()
    {
        $produto_id = Yii::$app->request->get('produto_id');
        $profile_id = Yii::$app->request->get('profile_id');

        if (!$produto_id || !$profile_id) {
            return [
                'success' => false,
                'message' => 'Os parâmetros produto_id e profile_id são obrigatórios.'
            ];
        }

        $model = $this->modelClass::find()->where(['produto_id' => $produto_id, 'profile_id' => $profile_id])->one();

        if ($model) {
            return [
                'success' => true,
                'message' => 'O produto está nos favoritos.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'O produto não está nos favoritos.'
            ];
        }
    }

    public function actionAddfav($idProduto, $idProfile)
    {
        if (!$idProduto || !$idProfile) {
            return [
                'success' => false,
                'message' => 'Os parâmetros idProduto e idProfile são obrigatórios.'
            ];
        }

        $model = $this->modelClass::find()->where(['produto_id' => $idProduto, 'profile_id' => $idProfile])->one();

        if ($model) {
            $model->delete();
            return [
                'success' => true,
                'message' => 'O produto foi removido dos favoritos.'
            ];
        } else {
            $model = new Favorito();
            $model->profile_id = $idProfile;
            $model->produto_id = $idProduto;

            if ($model->save()) {
                return [
                    'success' => true,
                    'message' => 'O produto foi adicionado aos favoritos.',
                    'data' => [
                        'idFavorito' => $model->idfavorito
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao adicionar o produto aos favoritos.',
                    'errors' => $model->errors
                ];
            }
        }
    }

    public function actionRemovefav($idfavorito, $idprofile)
    {
        $model = $this->modelClass::findOne([
            'idfavorito' => $idfavorito,
            'profile_id' => $idprofile
        ]);

        if ($model) {
            $model->delete();
            return [
                'success' => true,
                'message' => 'Favorito removido com sucesso',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Favorito não existe.',
            ];
        }
    }

    public function actionProfilefav($profile_id)
    {
        $favoritos = $this->modelClass::find()->where(['profile_id' => $profile_id])->all();
        foreach ($favoritos as $favorito) {
            $data[] = [
                'idprofile' => $favorito->profile_id,
                'idfavorito' => $favorito->idfavorito,
                'idproduto' => $favorito->produto_id,
                'nomeproduto' => $favorito->produto->nome,
                'preco' => $favorito->produto->preco,
                'imagem' => $this->getImagem($favorito),
            ];
        }
        return [
        $data
        ];
    }
     public static function getImagem($favorito)
     {
         $baseUrl = "http://172.22.21.201/detailingleiria/dtlgleiwebapp/frontend/web/uploads/";

         if (!empty($favorito->produto->imagem)) {
             $primeiraImagem = $favorito->produto->imagem[0];
             return $baseUrl . $primeiraImagem->fileName;
         }
     }
}

