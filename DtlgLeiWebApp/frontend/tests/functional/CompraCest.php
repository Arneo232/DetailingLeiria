<?php
namespace frontend\tests\functional;

use common\models\User;
use frontend\tests\FunctionalTester;

class CompraCest
{
    public function _before(FunctionalTester $I)
    {
        $I->seeRecord(User::className(), ['username' => 'pedroagostinho']);
        $I->amLoggedInAs(User::findOne(['username' => 'pedroagostinho']));
    }

    public function tentarAdicionarAoCarrinho(FunctionalTester $I)
    {

        $I->amOnPage('/site/product');
        $I->click('.fa.fa-cart-plus','.dl-btn-primary');
        $I->see('1', '.boxed-1');
    }



      public function tentarFinalizarCompra(FunctionalTester $I)
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
