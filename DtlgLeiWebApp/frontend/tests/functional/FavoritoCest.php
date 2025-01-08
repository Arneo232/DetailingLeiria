<?php
namespace frontend\tests\functional;

use common\models\User;
use frontend\tests\FunctionalTester;

class FavoritoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->seeRecord(User::className(), ['username' => 'pedroagostinho']);
        $I->amLoggedInAs(User::findOne(['username' => 'pedroagostinho']));
    }

    // tests
    public function tentarAdicionarAoFavorito(FunctionalTester $I)
    {

        $I->amOnPage('/site/product');
        $I->click('.fa.fa-star', '.dl-btn-primary');
    }
}
