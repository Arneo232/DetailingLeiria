<?php
namespace backend\tests\unit;

use backend\tests\UnitTester;
use common\models\Produto;

class ExampleTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $produto = new Produto();
        $produto->nome = 'Produto test';
        $this->assertTrue($produto->validate([$produto->nome]));
        $produto->descricao = 'teste 123';
        $this->assertTrue($produto->validate([$produto->descricao]));
        $produto->preco = 100;
        $this->assertTrue($produto->validate([$produto->preco]));
        $produto->stock = 5;
        $this->assertTrue($produto->validate([$produto->stock]));
        $produto->idCategoria = 1;
        $this->assertTrue($produto->validate([$produto->idCategoria]));
        $produto->fornecedores_idfornecedores = 1;
        $this->assertTrue($produto->validate([$produto->fornecedores_idfornecedores]));
        $produto->idDesconto = 1;
        $this->assertTrue($produto->validate([$produto->idDesconto]));

        $this->assertTrue($produto->save());

        $imagem = new \common\models\Imagem();
        $imagem->fileName = "VkLzOt2JkJ7NKDe_OPzLNAnGUYLnvLO5.png";
        $imagem->produtoId = $produto->idProduto;
        $this->assertTrue($imagem->save());
    }
}
