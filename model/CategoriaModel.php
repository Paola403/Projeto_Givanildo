<?php
require_once __DIR__ . '/../config/db.php';

class CategoriaModel {
    private $pdo;
    private $table = 'tb_categoria'; // nome correto da tabela

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // ✅ LISTAR TODOS
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ BUSCAR POR ID
    public function buscarPorId($CATE_ID) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE CATE_ID = ?");
        $stmt->execute([$CATE_ID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ INSERIR NOVO REGISTRO
    public function inserir($descricao) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (CATE_DESCRICAO) VALUES (?)");
        return $stmt->execute([$descricao]);
    }

    // ✅ ATUALIZAR REGISTRO EXISTENTE
    public function atualizar($CATE_ID, $CATE_DESCRICAO) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} 
                                     SET CATE_DESCRICAO = ? 
                                     WHERE CATE_ID = ?");
        return $stmt->execute([$CATE_DESCRICAO, $CATE_ID]);
    }

    // ✅ EXCLUIR REGISTRO
    public function excluir($CATE_ID) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE CATE_ID = ?");
        return $stmt->execute([$CATE_ID]);
    }
}