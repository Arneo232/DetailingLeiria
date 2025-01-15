<?php

namespace backend\modules\api\controllers;

use common\models\User;
use common\models\Profile;
use frontend\models\SignupForm;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

class AuthController extends Controller
{
    public $user;
    public $modelClass = 'common\models\User';
    public function actionLogin()
    {
        $userModel = new $this->modelClass;
        $request = Yii::$app->request;
        $username = $request->getBodyParam('username');
        $password = $request->getBodyParam('password');

        $user = $userModel::find()->where(['username' => $username])->one();
        $profile = Profile::find()->where(['userId' => $user->id])->one();

        $auth_key = $user->getAuthKey();
        return['auth_key' => $auth_key, 'username' => $username, 'email' => $user->email, 'profile_id' => $profile->idprofile];
    }

    public function actionRegister()
    {
        if (empty(Yii::$app->request->post())) throw new BadRequestHttpException('O body do request está vazio!');

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {

            if ($model->signup())
                return [
                    'message' => 'Sucesso!'
                ];
            else
                throw new ServerErrorHttpException("Ocorreu um erro ao dar signup.");
        } else {
            throw new UnprocessableEntityHttpException(Json::encode($model->getErrors()));
        }
    }
}