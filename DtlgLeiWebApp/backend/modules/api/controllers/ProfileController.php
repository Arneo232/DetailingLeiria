<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\User;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use Yii;
use common\models\Profile;

class ProfileController extends ActiveController
{
    public $modelClass = 'common\models\Profile';
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

    public function actionPerfil($idprofile){
        $profile = Profile::findOne($idprofile);

        $data = [
            'idUtilizador' => $profile->user->id,
            'idProfile' => $profile->idprofile,
            'username' => $profile->user->username,
            'email' => $profile->user->email,
            'morada' => $profile->morada,
            'ntelefone' => $profile->ntelefone,
            'token' => $profile->user->auth_key
        ];

        return $data;
    }
}