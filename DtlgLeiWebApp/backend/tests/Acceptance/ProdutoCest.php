<?php


namespace backend\tests\Acceptance;

use backend\tests\AcceptanceTester;

class ProdutoCest
{
    // tests
    public function tryToCreateProduto(AcceptanceTester $I)
    {
        $I->amOnPage('site/login');
        $I->wait(3);
        $I->fillField('Username', 'admin');
        $I->fillField('Password', '12345678');
        $I->click('Sign In');
        $I->wait(3);

        $I->amOnPage('/produto/create');
        $I->wait(3);
        $I->see('Create Produto');
        $I->fillField('Nome', 'Produto teste');
        $I->fillField('Descricao', 'Descrição do produto teste');
        $I->fillField('Preco', '100');
        $I->fillField('Stock', '50');
        $I->selectOption('Categoria', 'Liquidos');
        $I->selectOption('Fornecedor', '3M');
        $I->selectOption('Desconto', '10');
        $I->attachFile('Imagens', 'produto.png');
        $I->wait(3);
        $I->click('Save');
        $I->wait(5);
    }
}
