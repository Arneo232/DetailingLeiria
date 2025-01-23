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

    public function actionEditperfil($idprofile)
    {
        $profile = Profile::findOne($idprofile);
        if (!$profile) {
            throw new \yii\web\NotFoundHttpException("Perfil não encontrado");
        }

        $data = Yii::$app->request->post();

        if (isset($data['username'])) {
            $profile->user->username = $data['username'];
        }
        if (isset($data['email'])) {
            $profile->user->email = $data['email'];
        }
        if (isset($data['morada'])) {
            $profile->morada = $data['morada'];
        }
        if (isset($data['ntelefone'])) {
            $profile->ntelefone = $data['ntelefone'];
        }

        if (isset($data['username']) || isset($data['email'])) {
            if (!$profile->user->save()) {
                return [
                    'success' => false,
                    'message' => 'Erro ao atualizar o username ou email',
                    'errors' => $profile->user->errors,
                ];
            }
        }

        if ($profile->validate() && $profile->save()) {
            return [
                'success' => true,
                'message' => 'Perfil atualizado com sucesso',
                'data' => [
                    'idUtilizador' => $profile->user->id,
                    'idProfile' => $profile->idprofile,
                    'username' => $profile->user->username,
                    'email' => $profile->user->email,
                    'morada' => $profile->morada,
                    'ntelefone' => $profile->ntelefone,
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Erro ao atualizar o perfil',
                'errors' => $profile->errors,
            ];
        }
    }


}