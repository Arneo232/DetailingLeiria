<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\User;
use backend\modules\api\components\CustomAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\web\Controller;
use common\models\Carrinho;
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

    public function actionCriarcarrinho()
    {
        $carrinho = new $this->modelClass;

        $profileId = Yii::$app->user->identity->idprofile;

        if (!$profileId) {
            return [
                'success' => false,
                'message' => 'Perfil de utilizador não encontrado.',
            ];
        }

        $carrinho->profile_id = $profileId;

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

    public function actionAddcarrinho($idprofile, $produto_id, $quantidade = 1)
    {
        $carrinho = $this->modelClass::find()->where(['idProfile' => $idprofile])->one();

        if (!$carrinho) {
            return [
                'success' => false,
                'message' => 'Carrinho não encontrado de acordo com o id do perfil.'
            ];
        }

        $linhascarrinho = Linhascarrinho::find()
            ->where(['carrinho_id' => $carrinho->idCarrinho, 'produtos_id' => $produto_id])
            ->one();

        if ($linhascarrinho) {
            $linhascarrinho->quantidade += $quantidade;
            if ($linhascarrinho->save()) {
                return [
                    'success' => true,
                    'message' => 'Quantidade do produto atualizada com sucesso.',
                    'data' => $linhascarrinho
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Falha ao atualizar quantidade do produto.',
                    'errors' => $linhascarrinho->errors
                ];
            }
        } else {
            $linhacarrinho = new Linhascarrinho();
            $linhacarrinho->carrinho_id = $carrinho->idCarrinho;
            $linhacarrinho->produtos_id = $produto_id;
            $linhacarrinho->quantidade = $quantidade;

            if ($linhacarrinho->save()) {
                return [
                    'success' => true,
                    'message' => 'Produto adicionado ao carrinho com sucesso.',
                    'data' => $linhacarrinho
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Falha ao adicionar o produto ao carrinho.',
                    'errors' => $linhacarrinho->errors
                ];
            }
        }
    }



}
