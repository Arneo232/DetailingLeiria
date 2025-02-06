<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\User;
use backend\modules\api\components\CustomAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\Carrinho;
use common\models\Profile;
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

    public function actionCarrinhoporid($idprofile){
        // Fetch the carrinho (cart) based on the profile ID
        $carrinho = Carrinho::find()->where(['idProfile' => $idprofile])->one();

        if (!$carrinho) {
            return [
                'success' => false,
                'message' => 'Não foi encontrado nenhum carrinho com esse id de perfil.',
            ];
        }

        $linhas = Linhascarrinho::find()->where(['carrinho_id' => $carrinho->idCarrinho])->all();
        $baseUrl = "http://172.22.21.201/detailingleiria/dtlgleiwebapp/frontend/web/uploads/";

        $dados = [];
        $metodoEntrega = $carrinho->metodoEntrega ? $carrinho->metodoEntrega->designacao : null;
        $metodoPagamento = $carrinho->metodoPagamento ? $carrinho->metodoPagamento->designacao : null;

        $dados[] = [
            'idCarrinho' => $carrinho->idCarrinho,
            'idProfile' => $carrinho->idProfile,
            'metodoEntrega' => $metodoEntrega,
            'metodoPagamento' => $metodoPagamento,
            'linhasCarrinho' => [],
            'total' => $carrinho->total
        ];
        foreach ($linhas as $linha) {
            $dados[0]['linhasCarrinho'][] = [
                'idLinhaCarrinho' => $linha->idLinhasCarrinho,
                'idProduto' => $linha->produtos_id,
                'nomeProduto' => $linha->produto->nome,
                'quantidade' => $linha->quantidade,
                'precounitario' => $linha->precounitario,
                'subtotal' => $linha->subtotal,
                'imagem' => $this->getImagem($linha),
            ];
        }

        return [
            $dados
        ];
    }

    public static function getImagem($linha)
    {
        $baseUrl = "http://172.22.21.201/detailingleiria/dtlgleiwebapp/frontend/web/uploads/";

        if (!empty($linha->produto->imagem)) {
            $primeiraImagem = $linha->produto->imagem[0];
            return $baseUrl . $primeiraImagem->fileName;
        }
    }

    public function actionCriarcarrinho()
    {
        $carrinho = new $this->modelClass;

        $request = \Yii::$app->request;
        $profileId = $request->getBodyParam('idprofile');

        if (!$profileId) {
            return [
                'success' => false,
                'message' => 'O ID do perfil é necessário.',
            ];
        }

        $profile = Profile::findOne($profileId);

        if (!$profile) {
            return [
                'success' => false,
                'message' => 'Perfil de utilizador não encontrado.',
            ];
        }

        $carrinho->idProfile = $profileId;

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
}
