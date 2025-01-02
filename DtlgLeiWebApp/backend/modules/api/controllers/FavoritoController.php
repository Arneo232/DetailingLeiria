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

    public function actionVerificafav($produto_id, $profile_id)
    {
        $model = $this->modelClass::find()->where(['produto_id' => $produto_id, 'profile_id' => $profile_id])->one();
        if ($model) {
            return true;
        } else {
            return false;
        }
    }

    public function actionAddFav($produto_id, $profile_id)
    {
        $model = $this->modelClass::find()->where(['produto_id' => $produto_id, 'profile_id' => $profile_id])->one();

        if ($model) {
            $model->delete();
            return false;
        } else {
            $model = new Favorito();
            $model->profile_id = $profile_id;
            $model->produto_id = $produto_id;
            $model->save();

            return true;
        }
    }

    public function actionRemovefav($idfavorito)
    {
        $model = $this->modelClass::findOne($idfavorito);

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

        if ($favoritos) {
            return $favoritos;
        } else {
            return [
                'success' => false,
                'message' => 'Não foram encontrados produtos favoritados deste utilizador.',
            ];
        }
    }
}

