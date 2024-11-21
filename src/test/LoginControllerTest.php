<?php

use Controller\LoginController;
use PHPUnit\Framework\TestCase;
use Banco\Database;

class LoginControllerTest extends TestCase
{
    private $dbMock;
    private $controller;
    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(Database::class);
        $this->controller = new LoginController($this->dbMock);
    }

    public function testLoginSuccess()
    {
        $this->dbMock->method('fetch')->willReturn(['nome' => 'teste']);

        $this->expectOutputString('{"message":"Login realizado com sucesso.","nome":"teste"}');

        $body = json_encode(['nome' => 'João Silva']);

        $this->controller->index($body);
    }

    public function testLoginSuccessMissingFields1()
    {
        $this->dbMock->method('fetch')->willReturn(['nome' => 'teste']);

        $this->expectOutputString('{"error":"Nome e obrigatorio."}');

        $body = json_encode([]);

        $this->controller->index($body);
    }

    public function testLoginSuccessNoExistUser()
    {
        $this->dbMock->method('fetch')->willReturn(null);

        $this->expectOutputString('{"error":"Nome nao encontrado."}');

        $body = json_encode(['nome' => 'teste']);

        $this->controller->index($body);
    }

}