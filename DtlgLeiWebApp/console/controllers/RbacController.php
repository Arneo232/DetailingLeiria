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

        $GestaoIndexCategorias = $auth->createPermission('GestaoIndexCategorias');
        $GestaoIndexCategorias->description = 'Permite visualizar o Gestão de Categorias';
        $auth->add($GestaoIndexCategorias);

        $FornecedorIndex = $auth->createPermission('FornecedorIndex');
        $FornecedorIndex->description = 'Permite visualizar a lista de fornecedores';
        $auth->add($FornecedorIndex);

        $DescontosIndex = $auth->createPermission('DescontosIndex');
        $DescontosIndex->description = 'Permite visualizar os descontos e gerir';
        $auth->add($DescontosIndex);

        $GestaoIndexProdutos = $auth->createPermission('GestaoIndexProdutos');
        $GestaoIndexProdutos->description = 'Permite visualizar o Gestão de Produtos';
        $auth->add($GestaoIndexProdutos);

        $GestaoMetodosPagamentos = $auth->createPermission('GestaoMetodosPagamentos');
        $GestaoMetodosPagamentos->description = 'Permite visualizar o Gestão de metodos de pagamentos';
        $auth->add($GestaoMetodosPagamentos);

        $GestaoMetodosEntrega = $auth->createPermission('GestaoMetodosEntrega');
        $GestaoMetodosEntrega->description = 'Permite visualizar o Gestão Métodos de Entrega';
        $auth->add($GestaoMetodosEntrega);

        $ProdutoIndexView = $auth->createPermission('ProdutoIndexView');
        $ProdutoIndexView->description = 'Permite visualizar a View dos produtos';
        $auth->add($ProdutoIndexView);

        $ProdutoIndexUpdate = $auth->createPermission('ProdutoIndexUpdate');
        $ProdutoIndexUpdate->description = 'Permite visualizar o Update dos produtos';
        $auth->add($ProdutoIndexUpdate);

        $ProdutoIndexDelete = $auth->createPermission('ProdutoIndexDelete');
        $ProdutoIndexDelete->description = 'Permite deletar os produtos';
        $auth->add($ProdutoIndexDelete);

       $ProdutoIndexCreate = $auth->createPermission('ProdutoIndexCreate');
        $ProdutoIndexCreate->description = 'Permite criar produtos';
        $auth->add($ProdutoIndexCreate);


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
        $auth->addChild($funcionario,$DescontosIndex);
        $auth->addChild($funcionario,$GestaoIndexProdutos);
        $auth->addChild($funcionario,$GestaoMetodosEntrega);


        // Papel: gestor (herda de funcionário, adiciona CRUD de categorias, pagamentos e entregas)
        $gestor = $auth->createRole('gestor');
        $auth->add($gestor);
        $auth->addChild($gestor,$GestaoIndexCategorias);
        $auth->addChild($gestor,$FornecedorIndex);
        $auth->addChild($gestor,$DescontosIndex);
        $auth->addChild($gestor,$GestaoMetodosEntrega);
        $auth->addChild($gestor,$GestaoMetodosPagamentos);
        $auth->addChild($gestor,$ProdutoIndexView);
        $auth->addChild($gestor,$ProdutoIndexCreate);
        $auth->addChild($gestor,$ProdutoIndexUpdate);
        $auth->addChild($gestor,$ProdutoIndexDelete);
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
        $auth->assign($funcionario, 7); // ID do funcionário
        $auth->assign($gestor, 8); // ID do gestor
    }
}
