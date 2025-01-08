<?php
namespace frontend\tests\functional;

use common\models\User;
use frontend\tests\FunctionalTester;

class CompraCest
{
    public function _before(FunctionalTester $I)
    {
        $I->seeRecord(User::className(), ['username' => 'cliente']);
        $I->amLoggedInAs(User::findOne(['username' => 'cliente']));
    }

    public function AdicionarAoCarrinho(FunctionalTester $I)
    {

        $I->amOnPage('/site/product');
        $I->click('.fa.fa-cart-plus','.dl-btn-primary');

    }



      public function FinalizarCompra(FunctionalTester $I)
    {
        $I->amOnPage('/carrinho/index');
        $I->click('Checkout', '.btn.btn-success');
        $I->selectOption('idMetodoPagamento', 'visa');
        $I->selectOption('idMetodoEntrega', 'CTT');
        $I->see('Finalizar Compra');
        $I->click('Finalizar Compra', '.btn-success');
        $I->see('Fatura');
    }

}
