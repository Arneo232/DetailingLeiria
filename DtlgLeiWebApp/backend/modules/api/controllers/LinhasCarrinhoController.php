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
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

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

        if ($linhaCarrinho) {
            $linhaCarrinho->quantidade += $quantidade;
            $produto = Produto::findOne($produto_id);
            if ($produto) {
                $linhaCarrinho->subtotal = $linhaCarrinho->quantidade * $produto->preco;
            }

            if ($linhaCarrinho->save(false)) {
                // Recalculate the cart total after the update
                $carrinho->total = LinhasCarrinho::find()->where(['carrinho_id' => $carrinho->idCarrinho])->sum('subtotal');
                $carrinho->save(false);

                return [
                    'success' => true,
                    'message' => 'Quantidade do produto atualizada com sucesso.',
                    'data' => $linhaCarrinho
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Falha ao atualizar quantidade do produto.',
                    'errors' => $linhaCarrinho->errors
                ];
            }
        } else {
            $produto = Produto::findOne($produto_id);
            if (!$produto) {
                return [
                    'success' => false,
                    'message' => 'Produto não encontrado.'
                ];
            }

            $linhaCarrinho = new LinhasCarrinho();
            $linhaCarrinho->carrinho_id = $carrinho->idCarrinho;
            $linhaCarrinho->produtos_id = $produto_id;
            $linhaCarrinho->quantidade = $quantidade;
            $linhaCarrinho->precounitario = $produto->preco;
            $linhaCarrinho->subtotal = $linhaCarrinho->precounitario * $linhaCarrinho->quantidade;

            if ($linhaCarrinho->save(false)) {
                $carrinho->total = LinhasCarrinho::find()->where(['carrinho_id' => $carrinho->idCarrinho])->sum('subtotal');
                $carrinho->save(false);

                return [
                    'success' => true,
                    'message' => 'Produto adicionado ao carrinho com sucesso.',
                    'data' => $linhaCarrinho
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Falha ao adicionar o produto ao carrinho.',
                    'errors' => $linhaCarrinho->errors
                ];
            }
        }
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

    public function actionAumentarlinha()
    {
        $idlinha = Yii::$app->request->post('idLinhasCarrinho');

        if (!$idlinha) {
            return [
                'success' => false,
                'message' => 'O ID da linha é necessário.',
            ];
        }

        $linhaCarrinho = LinhasCarrinho::findOne($idlinha);
        if (!$linhaCarrinho) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        $linhaCarrinho->quantidade += 1;
        $linhaCarrinho->subtotal = $linhaCarrinho->quantidade * $linhaCarrinho->precounitario;

        if (!$linhaCarrinho->save(false)) {
            throw new ServerErrorHttpException('Erro ao atualizar a linha do carrinho.');
        }

        $carrinho = $linhaCarrinho->carrinho;
        $carrinho->total = LinhasCarrinho::find()
            ->where(['carrinho_id' => $carrinho->idCarrinho])
            ->sum('subtotal');

        if (!$carrinho->save(false)) {
            throw new ServerErrorHttpException('Erro ao atualizar o total do carrinho.');
        }

        return [
            'success' => true,
            'message' => 'Quantidade aumentada com sucesso.',
            'linhaCarrinho' => $linhaCarrinho,
            'carrinhoTotal' => $carrinho->total,
        ];
    }

    public function actionDiminuirlinha()
    {
        $idlinha = Yii::$app->request->post('idLinhasCarrinho');

        if (!$idlinha) {
            return [
                'success' => false,
                'message' => 'O ID da linha é necessário.',
            ];
        }

        $linhaCarrinho = LinhasCarrinho::findOne($idlinha);
        if (!$linhaCarrinho) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        if ($linhaCarrinho->quantidade > 1) {
            $linhaCarrinho->quantidade -= 1;
            $linhaCarrinho->subtotal = $linhaCarrinho->quantidade * $linhaCarrinho->precounitario;

            if (!$linhaCarrinho->save(false)) {
                throw new ServerErrorHttpException('Erro ao atualizar a linha do carrinho.');
            }

            $carrinho = $linhaCarrinho->carrinho;
            $carrinho->total = LinhasCarrinho::find()
                ->where(['carrinho_id' => $carrinho->idCarrinho])
                ->sum('subtotal');

            if (!$carrinho->save(false)) {
                throw new ServerErrorHttpException('Erro ao atualizar o total do carrinho.');
            }
        } else {
            throw new BadRequestHttpException('A quantidade não pode ser menor que 1.');
        }

        return [
            'success' => true,
            'message' => 'Quantidade reduzida com sucesso.',
            'linhaCarrinho' => $linhaCarrinho,
            'carrinhoTotal' => $carrinho->total,
        ];
    }


    public function actionLinhasporidcarrinho()
    {
        $idCarrinho = Yii::$app->request->post('idCarrinho');

        if (!$idCarrinho) {
            return [
                'success' => false,
                'message' => 'O ID do carrinho é necessário.',
            ];
        }

        $carrinho = Carrinho::findOne($idCarrinho);

        if (!$carrinho) {
            return [
                'success' => false,
                'message' => 'Carrinho não encontrado.',
            ];
        }

        $linhasCarrinho = LinhasCarrinho::find()
            ->where(['carrinho_id' => $carrinho->idCarrinho])
            ->all();

        if (empty($linhasCarrinho)) {
            return [
                'success' => false,
                'message' => 'Não há produtos no carrinho.',
            ];
        }

        return [
            'success' => true,
            'message' => 'Linhas de carrinho encontradas com sucesso.',
            'data' => $linhasCarrinho,
        ];
    }
}
