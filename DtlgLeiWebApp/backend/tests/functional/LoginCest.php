<?php
namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\User;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * @param FunctionalTester $I
     */

    public function _before(FunctionalTester $I)
    {
        //$I->seeRecord(User::className(), ['username'=>'admin']);
        //$I->amLoggedInAs(User::findOne(['username' => 'admin']));
    }

    public function loginUser(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->fillField('Username', 'admin');
        $I->fillField('Password', '12345678');
        $I->click('Sign In');
    }
}
