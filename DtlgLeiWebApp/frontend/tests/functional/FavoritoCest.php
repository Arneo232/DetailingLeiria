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

    public function AdicionarAoFavorito(FunctionalTester $I)
    {
        $I->amOnPage('/frontend/web');
        $I->click('Products');
        $I->click('.fa.fa-star', 'a.btn.dl-btn-primary');

    }

    public function verificarNosFavoritos(FunctionalTester $I)
    {
        $I->amOnPage('/favorito/index');
        $I->seeElement('.card.h-100.shadow-sm');
    }

        public function removerDosFavoritos(FunctionalTester $I)
        {
            $I->amOnPage('/favorito/index');
            $I->seeElement('.btn.btn-sm.btn-danger');
            $I->click('.btn.btn-sm.btn-danger');
        }

}
