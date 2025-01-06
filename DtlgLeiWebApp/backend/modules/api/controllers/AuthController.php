<?php

namespace backend\modules\api\controllers;

use common\models\User;
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

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth'],
            'only' => ['login'],
        ];

        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            $this->user = $user;
            return $user;
        }
        throw new ForbiddenHttpException('No authentication'); //403
    }


    public function actionLogin()
    {
        if ($this->user->profile) {
            return [
                'token' => $this->user->auth_key,
                'id' => $this->user->id,
                'username' => $this->user->username,
                'email' => $this->user->email,
                'ntelefone' => $this->user->profile->ntelefone,
                'morada' => $this->user->profile->morada,
            ];
        } else {
            throw new BadRequestHttpException('Perfil não foi encontrado.');
        }
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