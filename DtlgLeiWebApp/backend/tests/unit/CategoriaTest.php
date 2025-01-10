<?php

namespace backend\tests\unit;

use backend\tests\UnitTester;
use common\models\Categoria;

class CategoriaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }
    
    public function testValidacoesCategoria()
    {
        $categoria = new Categoria();

        $categoria->designacao = null;
        $this->assertFalse($categoria->validate(['designacao']));
    }
    
    public function testCorretoCategoria()
    {
        $categoria = new Categoria();

        $categoria->designacao = 'Extras';
        $this->assertTrue($categoria->validate(['designacao']));

        $this->assertTrue($categoria->save());
    }

    public function testAtualizaCategoria(){
        $categoria = new Categoria();
        $categoria->designacao = 'Extras';

        $this->assertTrue($categoria->validate());
        $this->assertTrue($categoria->save());

        $categoriaId = $categoria->idCategoria;
        $categoriaCriada = Categoria::findOne($categoriaId);

        $this->assertNotNull($categoriaCriada);
        $this->assertEquals('Extras', $categoriaCriada->designacao);

        $categoriaCriada->designacao = 'Ambientadores';

        $this->assertTrue($categoriaCriada->save());

        $categoriaAtualizada = Categoria::findOne($categoriaId);
        $this->assertEquals('Ambientadores', $categoriaAtualizada->designacao);
    }

    public function testApagarCategoria(){
        $categoriaEncontrado = Categoria::findOne(['designacao' => 'Extras']);
        $this->assertNotNull($categoriaEncontrado);

        $this->assertTrue($categoriaEncontrado->delete() !== false);

        $categoriaApagar = Categoria::findOne(['designacao' => 'Extras']);
        $this->assertNull($categoriaApagar);
    }
}
