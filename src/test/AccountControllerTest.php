<?php

use PHPUnit\Framework\TestCase;
use Controller\AccountController;
use Banco\Database;

class AccountControllerTest extends TestCase
{
    private $dbMock;
    private $controller;
    protected function setUp(): void
    {

        $this->dbMock = $this->createMock(Database::class);


        $this->controller = new AccountController($this->dbMock);
    }

    public function testCreateAccountSuccess()
    {
        $this->dbMock->method('fetch')->willReturn(false);
        $this->dbMock->expects($this->once())
            ->method('insert')
            ->with(
                "INSERT INTO usuario (nome, email) VALUES (?, ?)",
                ['João Silva', 'joao.silva@email.com']
            );


        $body = json_encode(['nome' => 'João Silva', 'email' => 'joao.silva@email.com']);

        $this->controller->create($body);
    }

    public function testCreateAccountMissingFields()
    {

        $this->expectOutputString('{"error":"Nome e email sao obrigatorios."}');

        $this->controller->create();
    }
    public function testUpdateAccountSuccess()
    {
        $this->dbMock->method('fetch')->willReturn(['nome' => 'Old Name', 'email' => 'old@example.com']);


        $this->dbMock->expects($this->once())
            ->method('update')
            ->with(
                "UPDATE usuario SET email = ?, nome = ? WHERE nome = ?",
                ['new@example.com', 'Old Name2', 'Old Name']
            );

        $this->expectOutputString('{"message":"Usuario atualizado com sucesso."}');

        $body = json_encode([
            'nome' => 'Old Name',
            'novo_email' => 'new@example.com',
            'novo_nome' => 'Old Name2'
        ]);

        $this->controller->update($body);
    }

    public function testUpdateAccountMissingFields()
    {

        $this->expectOutputString('{"error":"Nome, novo_nome ou novo_email sao obrigatorios."}');

        $body = json_encode([]);

        $this->controller->update($body);
    }

    public function testDeleteAccountSuccess()
    {
        $this->dbMock->method('fetch')->willReturn(['nome' => 'Delete Me']);

        $this->dbMock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo("DELETE FROM usuario WHERE nome = ?"),
                $this->equalTo(['Delete Me'])
            );

        $this->expectOutputString('{"message":"Usuario deletado com sucesso."}');

        $body = json_encode([
            'nome' => 'Delete Me'
        ]);

        $this->controller->delete($body);
    }

    public function testDeleteAccountMissingFields()
    {
        $body = json_encode([]);

        $this->expectOutputString('{"error":"Nome e obrigatorio."}');

        $this->controller->delete($body);
    }

}
