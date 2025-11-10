<?php
// controllers/TarefaController.php

require_once __DIR__ . '/../config/db.php'; 
require_once __DIR__ . '/../model/TarefaModel.php';
require_once __DIR__ . '/../utils/SessionController.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Proteção: Somente usuários logados podem gerenciar tarefas
if (!SessionController::isLoggedIn()) {
    header('Location: ' . BASE_URL . '/view/user/index.php?error=not_logged_in');
    exit;
}

// Pega o ID do usuário logado (TAREFA_CLIENTE)
$cliente_id = SessionController::getIdUsuario();

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/index.php?error=invalid_request');
    exit;
}

// Pega a ação (criar, atualizar, excluir)
$action = $_POST['action'] ?? 'create'; // Padrão é 'create'

try {
    $tarefaModel = new TarefaModel();
    
    // Roteamento de Ações
    switch ($action) {
        case 'create':
            // 1. Recebe dados (incluindo a data de início)
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $data_inicio = $_POST['data_inicio'] ?? date('Y-m-d'); // Pega a data de início
            $data_fim = $_POST['data_fim'] ?? date('Y-m-d'); // Pega a data de fim
            $categoria_id = $_POST['categoria_id'] ?? null;
            
            // 2. Chama o Model com 6 parâmetros
            $tarefaModel->inserir($titulo, $descricao, $data_inicio, $data_fim, $cliente_id, $categoria_id);
            break;

        case 'update':
            // 1. Recebe dados
            $tarefa_id = $_POST['tarefa_id'] ?? null;
            if (!$tarefa_id) break; 

            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $data_inicio = $_POST['data_inicio'] ?? date('Y-m-d'); // Pega a data de início
            $data_fim = $_POST['data_fim'] ?? date('Y-m-d'); // Pega a data de fim
            $categoria_id = $_POST['categoria_id'] ?? null;

            // 2. Chama o Model com 7 parâmetros (incluindo o ID)
            $tarefaModel->atualizar($tarefa_id, $titulo, $descricao, $data_inicio, $data_fim, $categoria_id);
            break;

        case 'delete':
            // 1. Recebe o ID
            $tarefa_id = $_POST['tarefa_id'] ?? null;
            if (!$tarefa_id) break; 
            
            // 2. Chama o Model
            $tarefaModel->excluir($tarefa_id);
            break;

        case 'complete':
            // 1. Recebe o ID
            $tarefa_id = $_POST['tarefa_id'] ?? null;
            if (!$tarefa_id) break;
            
            // 2. Chama o Model
            $tarefaModel->marcarFinalizada($tarefa_id);
            break;
    }

    // Após qualquer ação, redireciona de volta para o mural
    header('Location: ' . BASE_URL . '/index.php?status=success');
    exit;

} catch (\Exception $e) {
    error_log("Erro no TarefaController: " . $e->getMessage());
    header('Location: ' . BASE_URL . '/index.php?status=error');
    exit;
}
?>