<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\User;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use Yii;

class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';
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

    public function actionContagem()
    {
        $usersmodel = new $this->modelClass;
        $usercontador = $usersmodel::find()->all();
        return ['contagem' => count($usercontador)];
    }

    public function actionComperfil()
    {
        $users = User::find()->all();

        if (!$users) {
            return [
                'success' => false,
                'message' => 'Não foram encontrados utilizadores nenhuns.'
            ];
        }

        $data = [];

        foreach ($users as $user) {
            $profile = $user->profile;

            $data[] = [
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'token' => $user->auth_key,
                ],
                'profile' => $profile ? [
                    'idprofile' => $profile->idprofile,
                    'morada' => $profile->morada,
                    'ntelefone' => $profile->ntelefone,
                ] : null
            ];
        }

        return [
            'success' => true,
            'message' => 'Todos os users foram encontrados com o respetivo perfil.',
            'data' => $data
        ];
    }
}
