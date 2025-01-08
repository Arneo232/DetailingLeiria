<?php

namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Categoria;

class CategoriaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    // Testes
    public function testCorretoCategoria()
    {
        $categoria = new Categoria();

        $categoria->designacao = 'Acessórios';
        $this->assertTrue($categoria->validate(['designacao']));

        $this->assertTrue($categoria->save());
    }

    public function testValidacoesCategoria()
    {
        $categoria = new Categoria();

        $categoria->designacao = null;
        $this->assertFalse($categoria->validate(['designacao']));
    }
}
