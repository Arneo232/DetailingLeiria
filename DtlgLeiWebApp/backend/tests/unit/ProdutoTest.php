<?php

namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Produto;

class ProdutoTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCorretoProduto()
    {
        $produto = new Produto();

        $produto->nome = 'Polidor';
        $this->assertTrue($produto->validate(['nome']));

        $produto->descricao = 'Polidor supremo para carros';
        $this->assertTrue($produto->validate(['descricao']));

        $produto->preco = 10;
        $this->assertTrue($produto->validate(['preco']));

        $produto->stock = 1;
        $this->assertTrue($produto->validate(['stock']));

        $produto->idCategoria = 2;
        $this->assertTrue($produto->validate(['idCategoria']));

        $produto->fornecedores_idfornecedores = 1;
        $this->assertTrue($produto->validate(['fornecedores_idfornecedores']));

        $produto->idDesconto = 1;
        $this->assertTrue($produto->validate(['idDesconto']));

        $this->assertTrue($produto->save());
    }

    public function testeValidacoesProduto()
    {
        $produto = new Produto();

        $produto->nome = null;
        $produto->preco = null;
        $produto->stock = null;
        $produto->descricao = null;

        $this->assertFalse($produto->validate());
    }
}