<?php

namespace Database;

use PDO;
use PDOException;

class Database {
    private $host = 'localhost';
    private $dbname = 'postgres';
    private $username = 'usuario';
    private $password = 'senha';
    private $pdo;

    public function __construct() {
        try {
        
            $this->pdo = new PDO("pgsql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }
    }


    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
            return false;
        }
    }


    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }


    public function fetch($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
    }


    public function insert($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $this->pdo->lastInsertId() : false;
    }


    public function update($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->rowCount() : 0;
    }


    public function delete($sql, $params = []) {
        return $this->update($sql, $params);
    }


    public function close() {
        $this->pdo = null;
    }
}
