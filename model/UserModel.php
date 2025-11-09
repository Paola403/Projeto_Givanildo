<?php
require_once __DIR__ . '/../config/db.php';


class UserModel {
    private $pdo;
    private $table = 'tb_cliente'; 

    public function __construct() {
        $db = new Database(); 
        $this->pdo = $db->getConnection();
    }

    public function inserir($nome, $login, $senha_hashed) {
        $sql = "INSERT INTO {$this->table} (CLI_NOME, CLI_LOGIN, CLI_SENHA) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([$nome, $login, $senha_hashed]);
    }

    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE CLI_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE CLI_ID = ?");
        return $stmt->execute([$id]);
    }


    public function buscarPorLogin($login) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE CLI_LOGIN = ?");
        $stmt->execute([$login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function atualizar($id, $nome, $login, $senha_hashed = null) {
        $sql = "UPDATE {$this->table} SET CLI_NOME = ?, CLI_LOGIN = ?";
        $params = [$nome, $login];

        if (!empty($senha_hashed)) {
            $sql .= ", CLI_SENHA = ?";
            $params[] = $senha_hashed;
        }

        $sql .= " WHERE CLI_ID = ?";
        $params[] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * NOVO MÉTODO ESSENCIAL: Autentica o usuário
     */
    public function autenticar($login, $senha_limpa) {
        $user = $this->buscarPorLogin($login);

        if ($user) {
            // Verifica se a senha fornecida corresponde ao hash no banco de dados
            // Usa password_verify para segurança
            if (password_verify($senha_limpa, $user['CLI_SENHA'])) {
                return $user; // Retorna o array do usuário em caso de sucesso
            }
        }
        return false; // Retorna false se o login não existir ou a senha for inválida
    }
}