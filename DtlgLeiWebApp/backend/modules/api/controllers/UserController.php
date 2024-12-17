<?php

namespace backend\modules\api\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;

class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }
    public function actionContagem()
    {
        $usersmodel = new $this->modelClass;
        $usercontador = $usersmodel::find()->all();
        return ['contagem' => count($usercontador)];
    }

}
