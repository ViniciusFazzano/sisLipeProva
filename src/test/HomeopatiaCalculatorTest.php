<?php

use PHPUnit\Framework\TestCase;
use Banco\Database;
use Controller\HomeopatiaCalculator;

class HomeopatiaCalculatorTest extends TestCase
{
    private $dbMock;
    private $controller;

    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(Database::class);
        $this->controller = new HomeopatiaCalculator($this->dbMock);
    }

    public function testCalcularSuccess()
    {
        $this->dbMock
            ->expects($this->once())
            ->method('insert'); // Verifica que o método salvarResultadoNoBanco foi chamado.

        $this->expectOutputString('{"message":"Calculo realizado com sucesso.","items":{"varQntSaco":10,"varKiloBatida":20,"varKiloSaco":30,"varQntCabeca":40,"varConsumoCabeca":50,"varGramaHomeopatiaCabeca":60,"varGramasHomeopatiaCaixa":70,"qntBatida":15,"qntCaixa":5142.857142857142,"varGramasHomeopatiaSaco":36000,"varKiloHomeopatiaBatida":24,"pesoTotal":300,"consumoCabecaKilo":0.05,"cabecaSaco":600}}');

        $body = json_encode([
            'qnt_saco' => 10,
            'kilo_batida' => 20,
            'kilo_saco' => 30,
            'qnt_cabeca' => 40,
            'consumo_cabeca' => 50,
            'grama_homeopatia_cabeca' => 60,
            'gramas_homeopatia_caixa' => 70,
        ]);

        $this->controller->calcular($body);
    }

    public function testCalcularMissingFields()
    {
        $this->expectOutputString(json_encode([
            'message' => 'Dados insuficientes para calcular a homeopatia.'
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $body = json_encode([
            'qnt_saco' => 10,
            'kilo_batida' => 20,
        ]); // Dados insuficientes para cálculo.

        $this->controller->calcular($body);
    }

    public function testUpdateSuccess()
    {
        $this->dbMock
            ->method('update')
            ->with(
                "UPDATE resultados SET qnt_caixa = ?, gramas_homeopatia_saco = ?, kilos_homeopatia_batida = ?, peso_total = ?, qnt_batida = ? WHERE id = ?",
                [25, 24000, 16, 300, 15, 1]
            );

        $this->expectOutputString("Resultado atualizado com sucesso.");

        $body = json_encode([
            'qnt_saco' => 10,
            'kilo_batida' => 20,
            'kilo_saco' => 30,
            'qnt_cabeca' => 40,
            'consumo_cabeca' => 50,
            'grama_homeopatia_cabeca' => 60,
            'gramas_homeopatia_caixa' => 70,
        ]);

        $this->controller->update(1, $body);
    }

    public function testDeleteSuccess()
    {
        $this->dbMock
            ->expects($this->once())
            ->method('delete')
            ->with("DELETE FROM resultados WHERE id = ?", [1]);

        $this->expectOutputString("Resultado deletado com sucesso.");

        $this->controller->delete(1);
    }

    public function testGetListSuccess()
    {
        $this->dbMock
            ->expects($this->once())
            ->method('fetchAll')
            ->with("SELECT * FROM resultados")
            ->willReturn([
                ['id' => 1, 'var_qnt_saco' => 10, 'var_kilo_batida' => 20],
                ['id' => 2, 'var_qnt_saco' => 15, 'var_kilo_batida' => 25],
            ]);

        $this->expectOutputString(json_encode([
            ['id' => 1, 'var_qnt_saco' => 10, 'var_kilo_batida' => 20],
            ['id' => 2, 'var_qnt_saco' => 15, 'var_kilo_batida' => 25],
        ]));

        $this->controller->getList();
    }

    public function testGetIdSuccess()
    {
        $this->dbMock
            ->expects($this->once())
            ->method('fetch')
            ->with("SELECT * FROM resultados WHERE id = ?", [1])
            ->willReturn(['id' => 1, 'var_qnt_saco' => 10, 'var_kilo_batida' => 20]);

        $this->expectOutputString(json_encode(['id' => 1, 'var_qnt_saco' => 10, 'var_kilo_batida' => 20]));

        $this->controller->getId(1);
    }

    public function testGetIdNotFound()
    {
        $this->dbMock
            ->expects($this->once())
            ->method('fetch')
            ->with("SELECT * FROM resultados WHERE id = ?", [1])
            ->willReturn(null);

        $this->expectOutputString("Resultado não encontrado.");

        $this->controller->getId(1);
    }
}
