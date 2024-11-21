<?php
namespace Controller;

use Banco\Database;
use Exception;
use PDO;
class AccountController
{
    private Database $db;

    public function __construct($database = null)
    {
        if ($database === null)
            $this->db = new Database();
        else
            $this->db = $database;
    }

    public function getBody($input = null)
    {
        if ($input === null) {
            $input = file_get_contents('php://input');
        }
        return json_decode($input, true);
    }


    public function create($input = null)
    {
        $body = $this->getBody($input);


        if (!isset($body['nome']) || !isset($body['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nome e email sao obrigatorios.']);
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
            echo json_encode(['error' => 'Email invalido.']);
            return;
        }

        try {
            // $this->db = new Database();


            $existingUser = $this->db->fetch('SELECT * FROM usuario WHERE email = ?', [$email]);
            if ($existingUser) {
                http_response_code(409);
                echo json_encode(['error' => 'Email ja cadastrado.']);
                return;
            }

            $this->db->insert(
                'INSERT INTO usuario (nome, email) VALUES (?, ?)',
                [$nome, $email]
            );

            http_response_code(201);
            echo json_encode(['message' => 'Conta criada com sucesso.']);
        } catch (Exception $e) {

            http_response_code(500);
            echo json_encode(['error' => 'Erro interno no servidor: ' . $e->getMessage()]);
        }
    }
    public function update($input = null)
    {
        $body = $this->getBody($input);

        if (!isset($body['nome']) || (!isset($body['novo_nome']) && !isset($body['novo_email']))) {
            http_response_code(400);
            echo json_encode(['error' => 'Nome, novo_nome ou novo_email sao obrigatorios.']);
            return;
        }

        $nome = trim($body['nome']);
        $novoNome = isset($body['novo_nome']) ? trim($body['novo_nome']) : null;
        $novoEmail = isset($body['novo_email']) ? trim($body['novo_email']) : null;

        try {
            // $this->db = new Database();

            $user = $this->db->fetch('SELECT * FROM usuario WHERE nome = ?', [$nome]);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['error' => 'Usuario nao encontrado.']);
                return;
            }

            if (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['error' => 'Email invalido.']);
                return;
            }

            $this->db->update('UPDATE usuario SET email = ?, nome = ? WHERE nome = ?', [$novoEmail,$novoNome, $nome]);


            http_response_code(200);
            echo json_encode(['message' => 'Usuario atualizado com sucesso.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro interno no servidor: ' . $e->getMessage()]);
        }
    }
    public function delete($input = null)
    {
        $body = $this->getBody($input);

        if (!isset($body['nome'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nome e obrigatorio.']);
            return;
        }

        $nome = trim($body['nome']);

        try {
            // $this->db = new Database();

            $user = $this->db->fetch('SELECT * FROM usuario WHERE nome = ?', [$nome]);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['error' => 'Usuario nao encontrado.']);
                return;
            }

            $this->db->delete('DELETE FROM usuario WHERE nome = ?', [$nome]);

            http_response_code(200);
            echo json_encode(['message' => 'Usuario deletado com sucesso.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro interno no servidor: ' . $e->getMessage()]);
        }
    }
}
