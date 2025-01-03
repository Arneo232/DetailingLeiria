<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\User;
use backend\modules\api\components\CustomAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\Carrinho;
use common\models\Venda;
use common\models\LinhasCarrinho;
use common\models\LinhasVenda;
use yii\web\ForbiddenHttpException;

class VendaController extends ActiveController
{
    public $modelClass = 'common\models\Venda';

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
                throw new ForbiddenHttpException('Proibido');
            }
        }
    }

    public function actionFinalizarcompra()
    {
        $token = Yii::$app->request->get('token');
        $user = User::findIdentityByAccessToken($token);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalido ou token em falta.'
            ];
        }

        $userId = $user->profile->idprofile;

        $idCarrinho = Yii::$app->request->post('idCarrinho');
        if (!$idCarrinho) {
            return [
                'success' => false,
                'message' => 'ID do carrinho é obrigatorio.'
            ];
        }

        $carrinho = Carrinho::findOne(['idCarrinho' => $idCarrinho, 'idProfile' => $userId]);

        if (!$carrinho) {
            return [
                'success' => false,
                'message' => 'Não foi encontrado um carrinho com este utilizador.'
            ];
        }

        $idMetodoEntrega = Yii::$app->request->post('idMetodoEntrega');
        $idMetodoPagamento = Yii::$app->request->post('idMetodoPagamento');

        if (!$idMetodoEntrega || !$idMetodoPagamento) {
            return [
                'success' => false,
                'message' => 'Os metodos de entrega e pagamento são obrigatorios.'
            ];
        }

        $carrinho->idMetodoEntrega = $idMetodoEntrega;
        $carrinho->idMetodoPagamento = $idMetodoPagamento;

        if (!$carrinho->save(false)) {
            return [
                'success' => false,
                'message' => 'Falha ao salvar os dados da compra.'
            ];
        }

        $venda = new Venda();
        $venda->idProfileFK = $userId;
        $venda->idCarrinhoFK = $carrinho->idCarrinho;
        $venda->total = $carrinho->total;
        $venda->datavenda = date('Y-m-d H:i:s');
        $venda->metodoPagamento_id = $carrinho->idMetodoPagamento;
        $venda->metodoEntrega_id = $carrinho->idMetodoEntrega;

        if (!$venda->save()) {
            return [
                'success' => false,
                'message' => 'Falha ao finalizar a compra.',
                'errors' => $venda->errors
            ];
        }

        $linhasCarrinho = LinhasCarrinho::findAll(['carrinho_id' => $carrinho->idCarrinho]);

        foreach ($linhasCarrinho as $linhaCarrinho) {
            $linhaVenda = new LinhasVenda();
            $linhaVenda->idVendaFK = $venda->idVenda;
            $linhaVenda->idProdutoFK = $linhaCarrinho->produtos_id;
            $linhaVenda->quantidade = $linhaCarrinho->quantidade;
            $linhaVenda->precounitario = $linhaCarrinho->precounitario;
            $linhaVenda->subtotal = $linhaCarrinho->subtotal;

            if (!$linhaVenda->save()) {
                return [
                    'success' => false,
                    'message' => 'Falha ao guardar as linhas da venda',
                    'errors' => $linhaVenda->errors
                ];
            }
        }

        LinhasCarrinho::deleteAll(['carrinho_id' => $carrinho->idCarrinho]);

        return [
            'success' => true,
            'message' => 'Compra efetuada com sucesso',
            'data' => [
                'venda' => $venda,
                'linhasVenda' => LinhasVenda::findAll(['idVendaFK' => $venda->idVenda])
            ]
        ];
    }

    public function actionVendasporperfil($idprofilefk)
    {
        $token = Yii::$app->request->get('token');
        $user = User::findIdentityByAccessToken($token);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalido ou token em falta.'
            ];
        }

        if ($user->profile->idprofile != $idprofilefk) {
            return [
                'success' => false,
                'message' => 'Sem autorização.'
            ];
        }

        $vendas = Venda::find()->where(['idProfileFK' => $idprofilefk])->all();

        if (empty($vendas)) {
            return [
                'success' => false,
                'message' => 'Não existem vendas associadas a este utilizador.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Vendas encontradas com sucesso.',
            'data' => $vendas
        ];
    }

    public function actionLinhasvendaporvenda($idvenda)
    {
        $token = Yii::$app->request->get('token');
        $user = User::findIdentityByAccessToken($token);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalido ou token em falta.'
            ];
        }

        $linhasVenda = LinhasVenda::find()->where(['idVendaFK' => $idvenda])->all();

        if (empty($linhasVenda)) {
            return [
                'success' => false,
                'message' => 'Não existem linhas da venda associadas a este utilizador.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Linhas da venda encontradas com sucesso.',
            'data' => $linhasVenda
        ];
    }

}
