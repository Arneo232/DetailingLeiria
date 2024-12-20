<?php

namespace backend\modules\api\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;

class DescontoController extends ActiveController
{
    public $modelClass = 'common\models\Desconto';

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
        $descontosmodel = new $this->modelClass;
        $descontoscontador = $descontosmodel::find()->all();
        return ['contagem' => count($descontoscontador)];
    }

}
