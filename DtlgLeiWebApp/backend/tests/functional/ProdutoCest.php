<?php
namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\User;

class ProdutoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->seeRecord(User::className(), ['username'=>'admin']);
        $I->amLoggedInAs(User::findOne(['username' => 'admin']));
    }

    // tests
    public function createProduto(FunctionalTester $I)
    {
        $I->amOnPage('/produto/create');
        $I->see('Create Produto');
        $I->fillField('Nome', 'Produto teste');
        $I->see('admin');
        $I->fillField('Descricao', 'Descrição do produto teste');
        $I->fillField('Preco', '100');
        $I->fillField('Stock', '50');
        $I->selectOption('Categoria', 'Liquidos');
        $I->selectOption('Fornecedor', '3M');
        $I->selectOption('Desconto', '10');
        $I->attachFile('Imagens', 'produto.png');
        $I->click('form button[type=submit]');
    }
}
