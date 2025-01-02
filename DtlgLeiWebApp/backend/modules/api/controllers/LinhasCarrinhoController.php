<?php

namespace backend\modules\api\controllers;

use Yii;
use backend\modules\api\components\CustomAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\User;
use common\models\Carrinho;
use common\models\Linhascarrinho;
use common\models\Produto;
use yii\web\ForbiddenHttpException;

class LinhasCarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\Linhascarrinho';

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

    public function actionAddlinha()
    {
        $token = Yii::$app->request->get('token');
        $user = User::findIdentityByAccessToken($token);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Inválido ou token errado.'
            ];
        }

        if (!$user->profile) {
            return [
                'success' => false,
                'message' => 'Perfil do utilizador não encontrado.'
            ];
        }

        $produto_id = Yii::$app->request->post('produto_id');
        $quantidade = Yii::$app->request->post('quantidade', 1);

        if (!$produto_id) {
            return [
                'success' => false,
                'message' => 'ID do produto é necessário.'
            ];
        }

        $profile_id = $user->profile->idprofile;

        $carrinho = Carrinho::find()->where(['idProfile' => $profile_id])->one();
        if (!$carrinho) {
            $carrinho = new Carrinho();
            $carrinho->idProfile = $profile_id;
            $carrinho->total = 0;
            $carrinho->save(false);
        }

        $linhaCarrinho = LinhasCarrinho::find()->where(['carrinho_id' => $carrinho->idCarrinho, 'produtos_id' => $produto_id])->one();

        if (!$linhaCarrinho) {
            $linhaCarrinho = new LinhasCarrinho();
            $linhaCarrinho->carrinho_id = $carrinho->idCarrinho;
            $linhaCarrinho->produtos_id = $produto_id;
            $linhaCarrinho->quantidade = $quantidade;
            $linhaCarrinho->precounitario = Produto::findOne($produto_id)->preco;
            $linhaCarrinho->subtotal = $linhaCarrinho->precounitario * $linhaCarrinho->quantidade;
        } else {
            $linhaCarrinho->quantidade += $quantidade;
            $linhaCarrinho->subtotal = $linhaCarrinho->precounitario * $linhaCarrinho->quantidade;
        }

        $linhaCarrinho->save(false);

        $carrinho->total = LinhasCarrinho::find()->where(['carrinho_id' => $carrinho->idCarrinho])->sum('subtotal');
        $carrinho->save(false);

        return [
            'success' => true,
            'message' => 'Produto adicionado ao carrinho com sucesso.',
            'data' => $linhaCarrinho
        ];
    }

    public function actionRemoverlinha(){
        $token = Yii::$app->request->get('token');
        $user = User::findIdentityByAccessToken($token);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalido ou token errado.'
            ];
        }

        if (!$user->profile) {
            return [
                'success' => false,
                'message' => 'Perfil do user não encontrado.'
            ];
        }

        $linhaCarrinhoId = Yii::$app->request->post('idLinhasCarrinho');

        if (!$linhaCarrinhoId) {
            return [
                'success' => false,
                'message' => 'ID da linha é necessário.'
            ];
        }

        $linhaCarrinho = LinhasCarrinho::findOne($linhaCarrinhoId);

        if (!$linhaCarrinho) {
            return [
                'success' => false,
                'message' => 'Linha não foi encontrada.'
            ];
        }

        $carrinho = Carrinho::findOne($linhaCarrinho->carrinho_id);

        if (!$carrinho || $carrinho->idProfile !== $user->profile->idprofile) {
            return [
                'success' => false,
                'message' => 'Esta linha não pertence a este utilizador.'
            ];
        }

        if ($linhaCarrinho->delete()) {
            $carrinho->total = LinhasCarrinho::find()
                ->where(['carrinho_id' => $carrinho->idCarrinho])
                ->sum('subtotal');
            $carrinho->save(false);

            return [
                'success' => true,
                'message' => 'Linha removida com sucesso.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Falha ao tentar remover a linha.',
                'errors' => $linhaCarrinho->errors
            ];
        }
    }
}
