<?php

namespace frontend\tests\unit;

use frontend\tests\UnitTester;
use common\models\Carrinho;

class CompraTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCorretoCompra()
    {
        $compra = new Carrinho();

        $compra->total = 120;
        $this->assertTrue($compra->validate(['total']));

        $compra->datavenda = null;
        $this->assertTrue($compra->validate(['datavenda']));

        $compra->idProfile = 34;
        $this->assertTrue($compra->validate(['idProfile']));

        $compra->idMetodoEntrega = 1;
        $this->assertTrue($compra->validate(['idMetodoEntrega']));

        $compra->idMetodoPagamento = 1;
        $this->assertTrue($compra->validate(['idMetodoPagamento']));

        $this->assertTrue($compra->save());
    }

    public function testeValidacoesCompra()
    {
        $compra = new Carrinho();

        $compra->total = null;
        $compra->datavenda = null;

        $this->assertFalse($compra->validate());
    }
}
