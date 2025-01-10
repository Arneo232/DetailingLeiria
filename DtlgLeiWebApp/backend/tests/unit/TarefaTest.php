<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Tarefa;


class TarefaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidacoesTarefa()
    {
        $tarefa = new Tarefa();

        $tarefa->descricao = null;
        $this->assertFalse($tarefa->validate(['descricao']));
        $tarefa->feito = null;
        $this->assertFalse($tarefa->validate(['feito']));
    }

    public function testCorretoTarefa()
    {
        $tarefa = new Tarefa();

        $tarefa->descricao = 'Agendar Reunião';
        $this->assertTrue($tarefa->validate(['designacao']));

        $tarefa->feito = False;
        $this->assertTrue($tarefa->validate(['feito']));

        $this->assertTrue($tarefa->save());
    }

    public function testAtualizaTarefa(){
        $tarefa = new Categoria();

        $tarefa->descricao = 'Agendar Reunião';
        $tarefa->feito = False;

        $this->assertTrue($tarefa->validate());
        $this->assertTrue($tarefa->save());

        $tarefaId = $tarefa->idTarefa;
        $tarefaCriada = Tarefa::findOne($tarefaId);

        $this->assertNotNull($tarefaCriada);
        $this->assertEquals('Agendar Reunião', $tarefaCriada->descricao);

        $this->assertNotNull($tarefaCriada);
        $this->assertEquals(False, $tarefaCriada->feito);

        $tarefa->descricao = 'Agendar Palestra';
        $tarefa->feito = True;

        $this->assertTrue($tarefaCriada->save());

        $tarefaAtualizada = Tarefa::findOne($tarefaId);
        $this->assertEquals('Agendar Palestra', $tarefaAtualizada->descricao);
        $this->assertEquals(True, $tarefaAtualizada->feito);
    }

    public function testApagarTarefa(){
        $tarefaEncontrado = Tarefa::findOne(['descricao' => 'Agendar Palestra']);
        $this->assertNotNull($tarefaEncontrado);
        $tarefaEncontrado = Tarefa::findOne(['feito' => True]);
        $this->assertNotNull($tarefaEncontrado);

        $this->assertTrue($tarefaEncontrado->delete() !== false);

        $tarefaApagar = Tarefa::findOne(['descricao' => 'Agendar Palestra']);
        $this->assertNull($tarefaApagar);
        $tarefaEncontrado = Tarefa::findOne(['feito' => True]);
        $this->assertNull($tarefaEncontrado);
    }
}
