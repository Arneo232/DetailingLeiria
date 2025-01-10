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

<<<<<<< Updated upstream
        $viewPost = $auth->createPermission('viewPost');
        $viewPost->description = 'Permite visualizar posts';
        $auth->add($viewPost);
=======
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

        $GestaoIndexTarefas = $auth->createPermission('GestaoIndexTarefas');
        $GestaoIndexTarefas->description = 'Permite visualizar o Gestão de Tarefas';
        $auth->add($GestaoIndexTarefas);

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

        $GestaoEncomendas = $auth->createPermission('GestaoEncomendas');
        $GestaoEncomendas->description = 'Permite visualizar o Gestão encomendas';
        $auth->add($GestaoEncomendas);

        $GestaoAvaliacoes = $auth->createPermission('GestaoAvaliacoes');
        $GestaoAvaliacoes->description = 'Permite visualizar a Gestão de avaliacoes';
        $auth->add($GestaoAvaliacoes);

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
>>>>>>> Stashed changes

        // --- Papéis ---
        // Papel: cliente (permite apenas visualizar posts)
        $client = $auth->createRole('client');
        $auth->add($client);
        $auth->addChild($client, $viewPost);

        // Papel: funcionário (pode criar e atualizar posts)
        $funcionario = $auth->createRole('funcionario');
        $auth->add($funcionario);
<<<<<<< Updated upstream
        $auth->addChild($funcionario, $createPost);
        $auth->addChild($funcionario, $updatePost);
=======
        $auth->addChild($funcionario, $accessBackend);
        $auth->addChild($funcionario, $viewUser);
        $auth->addChild($funcionario,$DescontosIndex);
        $auth->addChild($funcionario,$GestaoIndexProdutos);
        $auth->addChild($funcionario,$GestaoMetodosEntrega);
        $auth->addChild($funcionario,$GestaoEncomendas);
        $auth->addChild($funcionario,$GestaoIndexTarefas);
>>>>>>> Stashed changes

        // Papel: gestor (herda permissões de funcionário)
        $gestor = $auth->createRole('gestor');
        $auth->add($gestor);
        $auth->addChild($gestor, $funcionario);
<<<<<<< Updated upstream
=======
        $auth->addChild($gestor, $GestaoAvaliacoes);
        $auth->addChild($funcionario,$GestaoIndexTarefas);
>>>>>>> Stashed changes

        // Papel: admin (herda permissões de gestor)
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $gestor);
<<<<<<< Updated upstream
=======
        $auth->addChild($admin, $accessBackend);
        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin,$UserIndexAccounts);
        $auth->addChild($admin,$viewUserAccounts);
        $auth->addChild($admin,$createUserAccounts);
        $auth->addChild($admin,$updateUserAccounts);
        $auth->addChild($admin,$deleteUserAccounts);
        $auth->addChild($admin, $GestaoAvaliacoes);
        $auth->addChild($funcionario,$GestaoIndexTarefas);
>>>>>>> Stashed changes

        // Atribuição de papéis para users
        $auth->assign($admin, 1);
        $auth->assign($client, 3);
        $auth->assign($funcionario, 4);
        $auth->assign($gestor, 5);
    }

   
}