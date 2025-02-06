<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\User;
use common\models\Avaliacao;
use common\models\Produto;
use common\models\Venda;
use common\models\Linhasvenda;
use yii\helpers\ArrayHelper;
use backend\modules\api\components\CustomAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class AvaliacaoController extends ActiveController
{
    public $modelClass = 'common\models\Avaliacao';

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

    public function actionFazeravaliacao($idprodutofk)
    {
        $token = Yii::$app->request->get('token');
        $user = User::findIdentityByAccessToken($token);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalido ou token em falta.'
            ];
        }

        $product = Produto::findOne($idprodutofk);
        if (!$product) {
            return [
                'success' => false,
                'message' => 'Produto não encontrado.'
            ];
        }

        $profileId = $user->profile->idprofile;

        $vendas = Venda::find()->where(['idProfileFK' => $profileId])->all();
        $idsVenda = ArrayHelper::getColumn($vendas, 'idVenda');
        $linhasVenda = LinhasVenda::find()->where(['idVendaFK' => $idsVenda])->all();
        $productId = ArrayHelper::getColumn($linhasVenda, 'idProdutoFK');

        if (!in_array($idprodutofk, $productId)) {
            return [
                'success' => false,
                'message' => 'É preciso comprar o produto para poder avaliar o mesmo.'
            ];
        }

        $reviewModel = new Avaliacao();
        $reviewModel->idProfileFK = $profileId;
        $reviewModel->idProdutoFK = $idprodutofk;

        if ($reviewModel->load(Yii::$app->request->post(), '') && $reviewModel->validate()) {
            if ($reviewModel->save()) {
                return [
                    'success' => true,
                    'message' => 'A sua avaliação foi enviada com sucesso.',
                    'data' => [
                    'idAvaliacao' => $reviewModel->idavaliacao,
                    'rating:' => $reviewModel->rating,
                    'comentário:' => $reviewModel->comentario,
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao submeter a avaliação.',
                    'errors' => $reviewModel->errors
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Dados da avaliação inválidos.',
                'errors' => $reviewModel->errors
            ];
        }
    }

    public function actionDelavaliacaoporid($idavaliacao)
    {
        $token = Yii::$app->request->get('token');
        $user = User::findIdentityByAccessToken($token);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalido ou token em falta.'
            ];
        }

        $avaliacao = Avaliacao::findOne($idavaliacao);

        if (!$avaliacao) {
            return [
                'success' => false,
                'message' => 'Avaliação não encontrada.'
            ];
        }

        if ($avaliacao->idProfileFK != $user->profile->idprofile) {
            return [
                'success' => false,
                'message' => 'Não tem permissão para apagar esta avaliação.'
            ];
        }

        if ($avaliacao->delete()) {
            return [
                'success' => true,
                'message' => 'Avaliação apagada com sucesso.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Falha ao apagar a avaliação.'
            ];
        }
    }

    public function actionAvaliacoesporproduto($idprodutofk)
    {
        $token = Yii::$app->request->get('token');
        $user = User::findIdentityByAccessToken($token);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Inválido ou token em falta.'
            ];
        }

        $avaliacoes = Avaliacao::find()->where(['idProdutoFK' => $idprodutofk])->all();

        if (empty($avaliacoes)) {
            return [
                'success' => false,
                'message' => 'Não foram encontradas avaliações associadas com o ID deste produto.'
            ];
        }

        $dados = [];

        foreach ($avaliacoes as $avaliacao) {
            $dados[] = [
                'idavaliacao' => $avaliacao->idavaliacao,
                'rating' => $avaliacao->rating,
                'comentario' => $avaliacao->comentario,
                'utilizador' => $avaliacao->profile->user->username,
                'idProdutoFK' => $avaliacao->idProdutoFK
            ];
        }

        return [
            $dados
        ];
    }


}
