<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\User;
use backend\modules\api\components\CustomAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\Carrinho;
use common\models\Profile;
use common\models\Linhascarrinho;
use yii\web\ForbiddenHttpException;

class CarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\Carrinho';

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

    public function actionCarrinhoporid($idprofile){
        $carrinho = Carrinho::find()->where(['idProfile' => $idprofile])->one();

        if (!$carrinho) {
            return [
                'success' => false,
                'message' => 'Não foi encontrado nenhum carrinho com esse id de perfil.',
            ];
        }

        return [
            'success' => true,
            'message' => 'Carrinho encontrado com sucesso.',
            'data' => $carrinho,
        ];
    }

    public function actionCriarcarrinho()
    {
        $carrinho = new $this->modelClass;

        $request = \Yii::$app->request;
        $profileId = $request->getBodyParam('idprofile');

        if (!$profileId) {
            return [
                'success' => false,
                'message' => 'O ID do perfil é necessário.',
            ];
        }

        $profile = Profile::findOne($profileId);

        if (!$profile) {
            return [
                'success' => false,
                'message' => 'Perfil de utilizador não encontrado.',
            ];
        }

        $carrinho->idProfile = $profileId;

        if ($carrinho->save()) {
            return [
                'success' => true,
                'message' => 'Carrinho criado com sucesso.',
                'data' => $carrinho,
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Falha ao criar o carrinho.',
                'errors' => $carrinho->errors,
            ];
        }
    }
}
