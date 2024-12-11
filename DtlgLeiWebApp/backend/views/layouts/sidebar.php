<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Gestão de Utilizadores', 'url' => ['/user/index'], 'icon' => 'fa fa-users'],
                    ['label' => 'Gestão de Categorias', 'url' => ['/categoria/index'], 'icon' => 'fa fa-icons'],
                    ['label' => 'Gestão de Métodos de Pagamento', 'url' => ['/metodopagamento/index'], 'icon' => 'fa fa-credit-card'],
                    ['label' => 'Gestão de Métodos de Entrega', 'url' => ['/metodoentrega/index'], 'icon' => 'fa fa-truck'],
                    ['label' => 'Gestão de Fornecedores', 'url' => ['/fornecedor/index'], 'icon' => 'fa fa-industry'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>