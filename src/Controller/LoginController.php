<?php

namespace Controller;

use Banco\Database;
use Exception;
class LoginController
{

  public function index()
  {
    $body = json_decode(file_get_contents('php://input'), true);

    if (!isset($body['nome'])) {
      http_response_code(400);
      echo json_encode(['error' => 'Nome é obrigatório.']);
      return;
    }

    $nome = trim($body['nome']);

    if (strlen($nome) < 3) {
      http_response_code(400);
      echo json_encode(['error' => 'O nome deve ter pelo menos 3 caracteres.']);
      return;
    }

    try {
      $db = new Database();

      $user = $db->fetch("SELECT * FROM usuario WHERE nome = ?", [$nome]);
      if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Nome não encontrado.']);
        return;
      }

      http_response_code(200);
      echo json_encode(['message' => 'Login realizado com sucesso.', 'nome' => $user['nome']]);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => 'Erro interno no servidor: ' . $e->getMessage()]);
    }
  }

}