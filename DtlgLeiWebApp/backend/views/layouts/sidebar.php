<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/images/Logo_Solo.png"
             alt="Logo"
             class="brand-image img-circle elevation-3"
             style="background-color: transparent; opacity: 1;">
        <span class="brand-text font-weight-light">Detailing Leiria</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= Yii::getAlias('@web') ?>/images/userBlue.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <?= \yii\helpers\Html::a(
                    Yii::$app->user->identity->username,
                    \yii\helpers\Url::toRoute(['user/view', 'id' => Yii::$app->user->id]),
                    ['class' => 'd-block']
                ) ?>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Gestão de Utilizadores', 'url' => ['/user/index'], 'icon' => 'fa fa-users', 'visible' => Yii::$app->user->can('UserIndexAccounts')],
                    ['label' => 'Gestão de Categorias', 'url' => ['/categoria/index'], 'icon' => 'fa fa-icons','visible' => Yii::$app->user->can('GestaoIndexCategorias')],
                    ['label' => 'Gestão de Fornecedores', 'url' => ['/fornecedor/index'], 'icon' => 'fa fa-industry','visible' => Yii::$app->user->can('FornecedorIndex')],
                    ['label' => 'Gestão de Descontos', 'url' => ['/desconto/index'], 'icon' => 'fa fa-tag','visible' => Yii::$app->user->can('DescontosIndex')],
                    ['label' => 'Gestão de Produtos', 'url' => ['/produto/index'], 'icon' => 'fa fa-spray-can','visible' => Yii::$app->user->can('GestaoIndexProdutos')],
                    ['label' => 'Gestão de Métodos de Pagamento', 'url' => ['/metodopagamento/index'], 'icon' => 'fa fa-credit-card','visible' => Yii::$app->user->can('GestaoMetodosPagamentos')],
                    ['label' => 'Gestão de Métodos de Entrega', 'url' => ['/metodoentrega/index'], 'icon' => 'fa fa-truck','visible' => Yii::$app->user->can('GestaoMetodosEntrega')],
                    ['label' => 'Gestão de Encomendas', 'url' => ['/venda/index'], 'icon' => 'fa fa-truck','visible' => Yii::$app->user->can('GestaoEncomendas')],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>