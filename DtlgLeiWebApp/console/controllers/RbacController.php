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
        $viewStatistics = $auth->createPermission('viewStatistics');
        $viewStatistics->description = 'Permite visualizar estatísticas de compras';
        $auth->add($viewStatistics);

        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Permite gerir contas de funcionários e utilizadores';
        $auth->add($manageUsers);

        $managePages = $auth->createPermission('managePages');
        $managePages->description = 'Permite gerir páginas';
        $auth->add($managePages);

        $manageProducts = $auth->createPermission('manageProducts');
        $manageProducts->description = 'Permite gerir produtos';
        $auth->add($manageProducts);

        $deleteComments = $auth->createPermission('deleteComments');
        $deleteComments->description = 'Permite remover comentários de produtos';
        $auth->add($deleteComments);

        $manageCategoriesTags = $auth->createPermission('manageCategoriesTags');
        $manageCategoriesTags->description = 'Permite gerir categorias e etiquetas';
        $auth->add($manageCategoriesTags);

        $managePayments = $auth->createPermission('managePayments');
        $managePayments->description = 'Permite gerir métodos de pagamento';
        $auth->add($managePayments);

        $manageDeliveries = $auth->createPermission('manageDeliveries');
        $manageDeliveries->description = 'Permite gerir métodos de entrega';
        $auth->add($manageDeliveries);

        // --- Papéis ---
        // Papel: cliente (visualiza estatísticas simples e produtos)
        $client = $auth->createRole('client');
        $auth->add($client);

        // Papel: funcionário (gestão básica de produtos e estatísticas)
        $funcionario = $auth->createRole('funcionario');
        $auth->add($funcionario);
        $auth->addChild($funcionario, $viewStatistics);
        $auth->addChild($funcionario, $manageProducts);
        $auth->addChild($funcionario, $deleteComments);

        // Papel: gestor (herda de funcionário, gerencia mais funcionalidades)
        $gestor = $auth->createRole('gestor');
        $auth->add($gestor);
        $auth->addChild($gestor, $funcionario);
        $auth->addChild($gestor, $manageCategoriesTags);
        $auth->addChild($gestor, $managePayments);
        $auth->addChild($gestor, $manageDeliveries);

        // Papel: admin (herda de gestor, gerencia usuários e permissões)
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $gestor);
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $managePages);

        // Atribuição de papéis para os users
        $auth->assign($admin, 1);
        $auth->assign($client, 3);
        $auth->assign($funcionario, 4);
        $auth->assign($gestor, 5);        
    }
}
