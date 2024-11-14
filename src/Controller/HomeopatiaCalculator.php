<?php

namespace Controller;

use Banco\Database;
use Exception;

class HomeopatiaCalculator
{
    public static function calcular()
    {

        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['qnt_saco'], $body['kilo_batida'], $body['kilo_saco'], $body['qnt_cabeca'], $body['consumo_cabeca'], $body['grama_homeopatia_cabeca'], $body['gramas_homeopatia_caixa'])) {
            throw new Exception("Dados insuficientes para calcular a homeopatia.");
        }


        $varQntSaco = $body['qnt_saco'];
        $varKiloBatida = $body['kilo_batida'];
        $varKiloSaco = $body['kilo_saco'];
        $varQntCabeca = $body['qnt_cabeca'];
        $varConsumoCabeca = $body['consumo_cabeca'];
        $varGramaHomeopatiaCabeca = $body['grama_homeopatia_cabeca'];
        $varGramasHomeopatiaCaixa = $body['gramas_homeopatia_caixa'];

        $resultados = array_fill(0, 6, 0);

        $qntBatida = 0;
        $qntCaixa = 0;
        $varGramasHomeopatiaSaco = 0;
        $varKiloHomeopatiaBatida = 0;
        $pesoTotal = 0;


        if ($varQntSaco > 0 && $varKiloSaco > 0) {
            $pesoTotal = $varQntSaco * $varKiloSaco;
        }

        if ($pesoTotal > 0 && $varKiloBatida > 0) {
            $qntBatida = intdiv($pesoTotal, $varKiloBatida);
        }

        if ($varKiloSaco > 0 && $varConsumoCabeca > 0 && $varGramaHomeopatiaCabeca > 0 && $qntBatida > 0 && $varGramasHomeopatiaCaixa > 0) {
            $consumoCabecaKilo = $varConsumoCabeca / 1000;
            $cabecaSaco = $varKiloSaco / $consumoCabecaKilo;
            $varGramasHomeopatiaSaco = $cabecaSaco * $varGramaHomeopatiaCabeca;
            $varKiloHomeopatiaBatida = (($varGramasHomeopatiaSaco / 1000) * $varQntSaco) / $qntBatida;
            $qntCaixa = (($varGramasHomeopatiaSaco / 1000) * $varQntSaco) / ($varGramasHomeopatiaCaixa / 1000);
        }

        $resultados = [
            $varQntSaco,
            $varKiloBatida,
            $varKiloSaco,
            $varQntCabeca,
            $varConsumoCabeca,
            $varGramaHomeopatiaCabeca,
            $varGramasHomeopatiaCaixa,
            $qntBatida,
            $qntCaixa,
            $varGramasHomeopatiaSaco,
            $varKiloHomeopatiaBatida,
            $pesoTotal,
            $consumoCabecaKilo,
            $cabecaSaco
        ];


        // $resultados[1] = (int) $qntCaixa;
        // $resultados[2] = (int) $varGramasHomeopatiaSaco;
        // $resultados[3] = (int) $varKiloHomeopatiaBatida;
        // $resultados[4] = (int) $pesoTotal;
        // $resultados[5] = (int) $qntBatida;


        self::salvarResultadoNoBanco($resultados);

        http_response_code(200);
        header("Content-Type: application/json");

        echo json_encode(
            [
                'message' => 'Calculo realizado com sucesso.',
                "items" => [
                    "varQntSaco" => $varQntSaco,
                    "varKiloBatida" => $varKiloBatida,
                    "varKiloSaco" => $varKiloSaco,
                    "varQntCabeca" => $varQntCabeca,
                    "varConsumoCabeca" => $varConsumoCabeca,
                    "varGramaHomeopatiaCabeca" => $varGramaHomeopatiaCabeca,
                    "varGramasHomeopatiaCaixa" => $varGramasHomeopatiaCaixa,
                    "qntBatida" => $qntBatida,
                    "qntCaixa" => $qntCaixa,
                    "varGramasHomeopatiaSaco" => $varGramasHomeopatiaSaco,
                    "varKiloHomeopatiaBatida" => $varKiloHomeopatiaBatida,
                    "pesoTotal" => $pesoTotal,
                    "consumoCabecaKilo" => $consumoCabecaKilo,
                    "cabecaSaco" => $cabecaSaco
                ]
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
    private static function salvarResultadoNoBanco($resultados)
    {
        try {
            $db = new Database();

            $sql = $db->insert(
                "INSERT INTO resultados (
                var_qnt_saco,
                var_kilo_batida,
                var_kilo_saco,
                var_qnt_cabeca,
                var_consumo_cabeca,
                var_grama_homeopatia_cabeca,
                var_gramas_homeopatia_caixa,
                qnt_batida,
                qnt_caixa,
                var_gramas_homeopatia_saco,
                var_kilo_homeopatia_batida,
                peso_total,
                consumo_cabeca_kilo,
                cabeca_saco
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?)",

                $resultados
            );

        } catch (Exception $e) {
            echo 'Erro ao salvar resultados: ' . $e->getMessage();
        }
    }
    public static function getList()
    {
        try {
            $db = new Database();
            $sql = "SELECT * FROM resultados";
            $resultados = $db->fetchAll($sql);
            echo json_encode($resultados);
        } catch (Exception $e) {
            echo 'Erro ao buscar os resultados: ' . $e->getMessage();
        }
    }
    public static function getId($id)
    {
        try {
            $db = new Database();
            $sql = "SELECT * FROM resultados WHERE id = ?";
            $resultados = $db->fetch($sql, [$id]);
            echo $resultados ? json_encode($resultados) : "Resultado não encontrado.";
        } catch (Exception $e) {
            echo 'Erro ao buscar o resultado: ' . $e->getMessage();
        }
    }
    public static function update($id)
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);


            if (!isset($body['qnt_saco'], $body['kilo_batida'], $body['kilo_saco'], $body['qnt_cabeca'], $body['consumo_cabeca'], $body['grama_homeopatia_cabeca'], $body['gramas_homeopatia_caixa'])) {
                throw new Exception("Dados insuficientes para calcular a homeopatia.");
            }


            $varQntSaco = $body['qnt_saco'];
            $varKiloBatida = $body['kilo_batida'];
            $varKiloSaco = $body['kilo_saco'];
            $varQntCabeca = $body['qnt_cabeca'];
            $varConsumoCabeca = $body['consumo_cabeca'];
            $varGramaHomeopatiaCabeca = $body['grama_homeopatia_cabeca'];
            $varGramasHomeopatiaCaixa = $body['gramas_homeopatia_caixa'];

            $resultados = array_fill(0, 6, 0);

            $qntBatida = 0;
            $qntCaixa = 0;
            $varGramasHomeopatiaSaco = 0;
            $varKiloHomeopatiaBatida = 0;
            $pesoTotal = 0;


            if ($varQntSaco > 0 && $varKiloSaco > 0) {
                $pesoTotal = $varQntSaco * $varKiloSaco;
            }

            if ($pesoTotal > 0 && $varKiloBatida > 0) {
                $qntBatida = intdiv($pesoTotal, $varKiloBatida);
            }

            if ($varKiloSaco > 0 && $varConsumoCabeca > 0 && $varGramaHomeopatiaCabeca > 0 && $qntBatida > 0 && $varGramasHomeopatiaCaixa > 0) {
                $consumoCabecaKilo = $varConsumoCabeca / 1000;
                $cabecaSaco = $varKiloSaco / $consumoCabecaKilo;
                $varGramasHomeopatiaSaco = $cabecaSaco * $varGramaHomeopatiaCabeca;
                $varKiloHomeopatiaBatida = (($varGramasHomeopatiaSaco / 1000) * $varQntSaco) / $qntBatida;
                $qntCaixa = (($varGramasHomeopatiaSaco / 1000) * $varQntSaco) / ($varGramasHomeopatiaCaixa / 1000);
            }


            $resultados[1] = (int) $qntCaixa;
            $resultados[2] = (int) $varGramasHomeopatiaSaco;
            $resultados[3] = (int) $varKiloHomeopatiaBatida;
            $resultados[4] = (int) $pesoTotal;
            $resultados[5] = (int) $qntBatida;

            $db = new Database();
            $db->update(
                "UPDATE resultados SET qnt_caixa = ?, gramas_homeopatia_saco = ?, kilos_homeopatia_batida = ?, peso_total = ?, qnt_batida = ? WHERE id = ?",
                [
                    $resultados[1],
                    $resultados[2],
                    $resultados[3],
                    $resultados[4],
                    $resultados[5],
                    $id
                ]
            );
            echo "Resultado atualizado com sucesso.";
        } catch (Exception $e) {
            echo 'Erro ao atualizar o resultado: ' . $e->getMessage();
        }
    }
    public static function delete($id)
    {
        try {
            $db = new Database();
            $db->delete("DELETE FROM resultados WHERE id = ?", [$id]);
            echo "Resultado deletado com sucesso.";
        } catch (Exception $e) {
            echo 'Erro ao deletar o resultado: ' . $e->getMessage();
        }
    }
}
