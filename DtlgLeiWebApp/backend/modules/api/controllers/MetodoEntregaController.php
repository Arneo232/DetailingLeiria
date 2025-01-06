<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\User;
use yii\filters\ContentNegotiator;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\web\Controller;
use Yii;

class MetodoentregaController extends ActiveController
{
    public $modelClass = 'common\models\Metodoentrega';

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
        $metodoEntregasmodel = new $this->modelClass;
        $metodoEntregascontador = $metodoEntregasmodel::find()->all();
        return ['contagem' => count($metodoEntregascontador)];
    }

    public function actionDelpornome($nomeentrega)
    {
        $climodel = new $this->modelClass;
        $recs = $climodel::deleteAll(['designacao' => $nomeentrega]);
        return "O método de entrega " . $recs . " foi apagado!";
    }

    public function actionPutpornome($nomeentrega)
    {
        $novo_designacao=\Yii::$app->request->post('designacao');
        $climodel = new $this->modelClass;
        $ret = $climodel::findOne(['designacao' => $nomeentrega]);
        if($ret)
        {
            return "O nome do método de entrega foi alterado para: " . $ret->designacao = $novo_designacao;
            $ret->save();
        }
        else
        {
            throw new \yii\web\NotFoundHttpException("Nome do metodo de entrega não existe");
        }
    }

    public function actionNovaentrega($nomeentrega)
    {
        $entregamodel = new $this->modelClass;

        $entregamodel->designacao = $nomeentrega;

        if ($entregamodel->save()) {
            return [
                'success' => true,
                'message' => "O método de entrega " . $entregamodel->designacao . " foi adicionado."
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Erro ao adicionar o método de entrega.',
                'errors' => $entregamodel->errors
            ];
        }
    }
}
