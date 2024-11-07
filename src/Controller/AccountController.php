<?php
namespace Controller;

use Banco\Database;
use Exception;
use PDO;
class AccountController
{
    public function create()
    {

        $body = json_decode(file_get_contents('php://input'), true);


        if (!isset($body['nome']) || !isset($body['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nome e email são obrigatórios.']);
            return;
        }

        $nome = trim($body['nome']);
        $email = trim($body['email']);


        if (strlen($nome) < 3) {
            http_response_code(400);
            echo json_encode(['error' => 'O nome deve ter pelo menos 3 caracteres.']);
            return;
        }


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Email inválido.']);
            return;
        }

        try {
            $db = new Database();


            $existingUser = $db->fetch("SELECT * FROM usuario WHERE email = ?", [$email]);
            if ($existingUser) {
                http_response_code(409);
                echo json_encode(['error' => 'Email já cadastrado.']);
                return;
            }


            $db->insert(
                "INSERT INTO usuario (nome, email) VALUES (?, ?)",
                [$nome, $email]
            );

            http_response_code(201);
            echo json_encode(['message' => 'Conta criada com sucesso.']);
        } catch (Exception $e) {

            http_response_code(500);
            echo json_encode(['error' => 'Erro interno no servidor: ' . $e->getMessage()]);
        }
    }
    public function update()
    {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['nome']) || (!isset($body['novo_nome']) && !isset($body['novo_email']))) {
            http_response_code(400);
            echo json_encode(['error' => 'Nome, novo_nome ou novo_email são obrigatórios.']);
            return;
        }

        $nome = trim($body['nome']);
        $novoNome = isset($body['novo_nome']) ? trim($body['novo_nome']) : null;
        $novoEmail = isset($body['novo_email']) ? trim($body['novo_email']) : null;

        try {
            $db = new Database();

            $user = $db->fetch("SELECT * FROM usuario WHERE nome = ?", [$nome]);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['error' => 'Usuário não encontrado.']);
                return;
            }

            if ($novoNome) {
                $db->update("UPDATE usuario SET nome = ? WHERE nome = ?", [$novoNome, $nome]);
            }

            if ($novoEmail) {
                if (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Email inválido.']);
                    return;
                }
                $db->update("UPDATE usuario SET email = ? WHERE nome = ?", [$novoEmail, $nome]);
            }

            http_response_code(200);
            echo json_encode(['message' => 'Usuário atualizado com sucesso.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro interno no servidor: ' . $e->getMessage()]);
        }
    }
    public function delete()
    {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['nome'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nome é obrigatório.']);
            return;
        }

        $nome = trim($body['nome']);

        try {
            $db = new Database();

            $user = $db->fetch("SELECT * FROM usuario WHERE nome = ?", [$nome]);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['error' => 'Usuário não encontrado.']);
                return;
            }

            $db->delete("DELETE FROM usuario WHERE nome = ?", [$nome]);

            http_response_code(200);
            echo json_encode(['message' => 'Usuário deletado com sucesso.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro interno no servidor: ' . $e->getMessage()]);
        }
    }
}
