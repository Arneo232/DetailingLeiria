<?php


namespace frontend\tests\unit;

use frontend\tests\UnitTester;
use common\models\Avaliacao;


class AvaliacaoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCorretoAvaliacao()
    {
        $avaliacao = new Avaliacao();

        $avaliacao->comentario = 'Excelente produto!';
        $this->assertTrue($avaliacao->validate(['comentario']));

        $avaliacao->rating = 4;
        $this->assertTrue($avaliacao->validate(['rating']));

        $avaliacao->idProfileFK = 34;
        $this->assertTrue($avaliacao->validate(['idProfileFK']));

        $avaliacao->idProdutoFK = 25;
        $this->assertTrue($avaliacao->validate(['idProdutoFK']));

        $this->assertTrue($avaliacao->save());
    }
    public function testeValidacoesAvaliacao()
    {
        $avaliacao = new Avaliacao();

        $avaliacao->comentario = null;
        $avaliacao->rating = null;
        $this->assertFalse($avaliacao->validate());

    }
}
