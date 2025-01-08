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
    }

    public function testCriacaoErradaUser(){
        $user = new User();
        $user->username = "nomeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee";
        $user->email = "emailinvalidoexemplo";
        $user->setPassword('pass');
        $user->generateAuthKey();
        $this->assertFalse($user->validate());

        $this->assertFalse($user->save());
    }

    public function testCriacaoCorretaUser(){
        $user = new User();
        $user->username = 'userteste';
        $user->email = 'userteste@detailingleiria.pt';
        $user->setPassword('12345678');
        $user->generateAuthKey();
        $this->assertTrue($user->validate());

        $this->assertTrue($user->save());
    }
}
