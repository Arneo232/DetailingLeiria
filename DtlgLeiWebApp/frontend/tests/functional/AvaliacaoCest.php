<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\models\Avaliacao;
use common\models\User;

class AvaliacaoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->seeRecord(User::className(), ['username' => 'cliente']);
        $I->amLoggedInAs(User::findOne(['username' => 'cliente']));
    }

    // tests
    public function tentaFazerAvaliacao(FunctionalTester $I)
    {
        $I->amOnPage('/site/product-detail?idProduto=25');
        $I->selectOption('Avaliacao[rating]', '4');
        $I->fillField('Avaliacao[comentario]', 'Avaliação teste.');
        $I->click('Submeter Avaliação');
    }

    public function tentaRemoverAvaliacao(FunctionalTester $I)
    {
        $I->amOnPage('/site/product-detail?idProduto=25');
        $I->click('Remover', '.btn-remove-avaliacao');
    }
}
