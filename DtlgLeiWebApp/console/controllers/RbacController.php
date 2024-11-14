<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Remover tudo para começar do zero
        $auth->removeAll();

        // --- Permissões ---
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Permite criar posts';
        $auth->add($createPost);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Permite atualizar posts';
        $auth->add($updatePost);

        $viewPost = $auth->createPermission('viewPost');
        $viewPost->description = 'Permite visualizar posts';
        $auth->add($viewPost);

        // --- Papéis ---
        // Papel: cliente (permite apenas visualizar posts)
        $client = $auth->createRole('client');
        $auth->add($client);
        $auth->addChild($client, $viewPost);

        // Papel: funcionário (pode criar e atualizar posts)
        $funcionario = $auth->createRole('funcionario');
        $auth->add($funcionario);
        $auth->addChild($funcionario, $createPost);
        $auth->addChild($funcionario, $updatePost);

        // Papel: gestor (herda permissões de funcionário)
        $gestor = $auth->createRole('gestor');
        $auth->add($gestor);
        $auth->addChild($gestor, $funcionario);

        // Papel: admin (herda permissões de gestor)
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $gestor);

        // Atribuição de papéis para users
        $auth->assign($admin, 1);
        $auth->assign($client, 3);
        $auth->assign($funcionario, 4);
        $auth->assign($gestor, 5);
    }

   
}