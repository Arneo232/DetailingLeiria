<?php

namespace frontend\tests\unit;

use frontend\tests\UnitTester;
use common\models\User;

class UserTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidacaoUser()
    {
        $user = new User();

        $user->username = null;
        $this->assertFalse($user->validate(['username']));

        $user->username = 'nomeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $this->assertFalse($user->validate(['username']));

        $user->username = "admin";
        $this->assertFalse($user->validate(['username']));

        $user->email = null;
        $this->assertFalse($user->validate(['email']));

        $user->email = "admin@detailingleiria.pt";
        $this->assertFalse($user->validate(['email']));

        $passwordTeste = 'pass';
        $user->setPassword($passwordTeste);
        $this->assertFalse($user->validatePassword('passerrada'));
    }

    public function testCriacaoUser(){
        $user = new User();
        $user->username = "nomeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee";
        $this->assertFalse($user->validate(['username']));
        $user->email = "emailinvalidoexemplo";
        $this->assertFalse($user->validate(['email']));

        $passwordTeste = 'pass';
        $user->setPassword($passwordTeste);
        $this->assertFalse($user->validatePassword('passerrada'));
    }
}
