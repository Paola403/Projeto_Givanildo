<?php

require_once __DIR__ . '/../config/db.php';

class TarefaModel {
    private $pdo;
    private $table = 'tb_tarefa';

    public function __construct() {
        $db = new Database(); // Instancia sua classe de conexão
        $this->pdo = $db->getConnection();
    }

    /**
     * Lista todas as tarefas de um cliente específico (usuário logado).
     * Esta é a consulta principal para exibir o mural.
     */
    public function listarPorCliente($cliente_id) {
        // Incluímos um JOIN para já trazer o nome da categoria
        $sql = "SELECT t.*, c.CATE_DESCRICAO 
                FROM {$this->table} t
                LEFT JOIN tb_categoria c ON t.TAREFA_CATEGORIA = c.CATE_ID
                WHERE t.TAREFA_CLIENTE = ?
                ORDER BY t.TAREFA_DATA_FIM ASC";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cliente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca uma tarefa específica pelo ID.
     * Usado para carregar dados no modal antes de ATUALIZAR.
     */
    public function buscarPorId($tarefa_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE TAREFA_ID = ?");
        $stmt->execute([$tarefa_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insere uma nova tarefa no banco.
     */
    public function inserir($titulo, $descricao, $data_inicio, $data_fim, $cliente_id, $categoria_id) {
        $sql = "INSERT INTO {$this->table} 
                    (TAREFA_TITULO, TAREFA_DESCRICAO, TAREFA_DATA_INICIO, TAREFA_DATA_FIM, TAREFA_STATUS, TAREFA_FINALIZADA, TAREFA_CLIENTE, TAREFA_CATEGORIA) 
                VALUES 
                    (?, ?, ?, ?, 'P', 0, ?, ?)"; // Trocamos NOW() por ?
        
        $stmt = $this->pdo->prepare($sql);
        // A ordem dos parâmetros deve bater com os '?'
        return $stmt->execute([$titulo, $descricao, $data_inicio, $data_fim, $cliente_id, $categoria_id]);
    }

    /**
     * Atualiza uma tarefa existente.
     */
    public function atualizar($id, $titulo, $descricao, $data_inicio, $data_fim, $categoria_id, $status = 'P', $finalizada = 0) {
        $sql = "UPDATE {$this->table} SET 
                    TAREFA_TITULO = ?, 
                    TAREFA_DESCRICAO = ?, 
                    TAREFA_DATA_INICIO = ?, 
                    TAREFA_DATA_FIM = ?, 
                    TAREFA_CATEGORIA = ?,
                    TAREFA_STATUS = ?,
                    TAREFA_FINALIZADA = ?
                WHERE TAREFA_ID = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titulo, $descricao, $data_inicio, $data_fim, $categoria_id, $status, $finalizada, $id]);
    }

    /**
     * Exclui uma tarefa do banco.
     */
    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE TAREFA_ID = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Marca uma tarefa como finalizada (Exemplo de método de atualização rápida).
     */
    public function marcarFinalizada($id) {
        $sql = "UPDATE {$this->table} SET TAREFA_STATUS = 'F', TAREFA_FINALIZADA = 1, TAREFA_DATA_FINALIZADA = NOW() WHERE TAREFA_ID = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

public function listarCategoriasMaisUsadas($cliente_id) {
        $sql = "SELECT 
                    c.CATE_ID, /* <--- ADICIONADO: Essencial para o botão de edição (data-id) */
                    c.CATE_DESCRICAO,
                    COALESCE(COUNT(t.TAREFA_CATEGORIA), 0) AS total_usos
                FROM tb_categoria c 
                LEFT JOIN tb_tarefa t 
                    ON c.CATE_ID = t.TAREFA_CATEGORIA 
                    AND t.TAREFA_CLIENTE = ? /* Primeiro placeholder */
                /* NOVO: Filtrar categorias pelo cliente (Assumindo que CATE_CLIENTE exista) */
                GROUP BY c.CATE_ID, c.CATE_DESCRICAO 
                ORDER BY total_usos DESC, c.CATE_DESCRICAO ASC";
                
        $stmt = $this->pdo->prepare($sql);
        
        // CORREÇÃO DE EXECUÇÃO: Agora são 2 placeholders (?). Precisamos de 2 IDs.
        $stmt->execute([$cliente_id]); 
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>