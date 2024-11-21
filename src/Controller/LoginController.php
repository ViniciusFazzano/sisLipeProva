<?php

namespace Controller;

use Banco\Database;
use Exception;
class LoginController
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

  public function index($input = null)
  {
    $body = $this->getBody($input);

    if (!isset($body['nome'])) {
      http_response_code(400);
      echo json_encode(['error' => 'Nome e obrigatorio.']);
      return;
    }

    $nome = trim($body['nome']);

    if (strlen($nome) < 3) {
      http_response_code(400);
      echo json_encode(['error' => 'O nome deve ter pelo menos 3 caracteres.']);
      return;
    }

    try {


      $user = $this->db->fetch("SELECT * FROM usuario WHERE nome = ?", [$nome]);
      if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Nome nao encontrado.']);
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