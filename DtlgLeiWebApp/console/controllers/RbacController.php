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

        $permissions = []; // Para armazenar permissões criadas

        foreach ($entities as $entity => $description) {
            foreach (['create', 'read', 'update', 'delete'] as $action) {
                $permissionName = "{$action}{$entity}";
                $permission = $auth->createPermission($permissionName);
                $permission->description = "Permite {$action} {$description}";
                $auth->add($permission);
                $permissions[$entity][$action] = $permission;
            }
        }

        // --- Papéis ---
        // Papel: cliente (somente leitura de produtos e comentários)
        $client = $auth->createRole('client');
        $auth->add($client);
        $auth->addChild($client, $permissions['Products']['read']);
        $auth->addChild($client, $permissions['Comments']['read']);

        // Papel: funcionário (CRUD de produtos e comentários)
        $funcionario = $auth->createRole('funcionario');
        $auth->add($funcionario);
        foreach (['Products', 'Comments'] as $entity) {
            foreach (['create', 'read', 'update', 'delete'] as $action) {
                $auth->addChild($funcionario, $permissions[$entity][$action]);
            }
        }

        // Papel: gestor (herda de funcionário, adiciona CRUD de categorias, pagamentos e entregas)
        $gestor = $auth->createRole('gestor');
        $auth->add($gestor);
        $auth->addChild($gestor, $funcionario);
        foreach (['CategoriesTags', 'Payments', 'Deliveries'] as $entity) {
            foreach (['create', 'read', 'update', 'delete'] as $action) {
                $auth->addChild($gestor, $permissions[$entity][$action]);
            }
        }

        // Papel: admin (herda de gestor, adiciona CRUD de usuários e páginas)
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $gestor);
        foreach (['Users', 'Pages'] as $entity) {
            foreach (['create', 'read', 'update', 'delete'] as $action) {
                $auth->addChild($admin, $permissions[$entity][$action]);
            }
        }

        // Atribuir papéis aos usuários
        $auth->assign($admin, 1); // ID do admin
        $auth->assign($client, 3); // ID do cliente
        $auth->assign($funcionario, 4); // ID do funcionário
        $auth->assign($gestor, 5); // ID do gestor
    }
}
