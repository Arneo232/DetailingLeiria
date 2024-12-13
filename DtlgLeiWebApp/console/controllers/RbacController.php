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

        // --- Definição de Entidades e Permissões CRUD ---
        $entities = [
            'Products' => 'produtos',
            'Pages' => 'páginas',
            'Users' => 'contas de utilizadores e funcionários',
            'Comments' => 'comentários',
            'CategoriesTags' => 'categorias e etiquetas',
            'Payments' => 'métodos de pagamento',
            'Deliveries' => 'métodos de entrega',
        ];

        // Permissão de acesso ao backend
        $accessBackend = $auth->createPermission('accessBackend');
        $accessBackend->description = 'Permite acesso ao backend do sistema';
        $auth->add($accessBackend);

        // Permissão de visualizar perfil do usuário
        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = 'Permite ao usuário visualizar seu próprio perfil';
        $auth->add($viewUser);

        $UserIndexAccounts = $auth->createPermission('UserIndexAccounts');
        $UserIndexAccounts->description = 'Permite visualizar o index dos utilizadores';
        $auth->add($UserIndexAccounts);

        $viewUserAccounts = $auth->createPermission('viewUserAccounts');
        $viewUserAccounts->description = 'Permite visualizar contas de utilizadores e funcionários';
        $auth->add($viewUserAccounts);

        $createUserAccounts = $auth->createPermission('createUserAccounts');
        $createUserAccounts->description = 'Permite criar contas de utilizadores e funcionários';
        $auth->add($createUserAccounts);

        $updateUserAccounts = $auth->createPermission('updateUserAccounts');
        $updateUserAccounts->description = 'Permite editar contas de utilizadores e funcionários';
        $auth->add($updateUserAccounts);

        $deleteUserAccounts = $auth->createPermission('deleteUserAccounts');
        $deleteUserAccounts->description = 'Permite deletar contas de utilizadores e funcionários';
        $auth->add($deleteUserAccounts);

        // --- Papéis ---
        // Papel: cliente (somente leitura de produtos e comentários)
        $client = $auth->createRole('client');
        $auth->add($client);
        $auth->addChild($client, $viewUser);

        // Papel: funcionário (CRUD de produtos e comentários, acesso ao backend)
        $funcionario = $auth->createRole('funcionario');
        $auth->add($funcionario);
        $auth->addChild($funcionario, $accessBackend);
        $auth->addChild($funcionario, $viewUser);


        // Papel: gestor (herda de funcionário, adiciona CRUD de categorias, pagamentos e entregas)
        $gestor = $auth->createRole('gestor');
        $auth->add($gestor);
        $auth->addChild($gestor, $funcionario);


        // Papel: admin (herda de gestor, adiciona CRUD de usuários e páginas)
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $gestor);
        $auth->addChild($admin, $accessBackend);
        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin,$UserIndexAccounts);
        $auth->addChild($admin,$viewUserAccounts);
        $auth->addChild($admin,$createUserAccounts);
        $auth->addChild($admin,$updateUserAccounts);
        $auth->addChild($admin,$deleteUserAccounts);



        // Atribuir papéis aos usuários
        $auth->assign($admin, 1); // ID do admin
        $auth->assign($client, 3); // ID do cliente
        $auth->assign($funcionario, 4); // ID do funcionário
        $auth->assign($gestor, 5); // ID do gestor
    }
}
