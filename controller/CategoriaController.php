<?php

// Inclua a classe de modelo
require_once __DIR__ . '/../model/CategoriaModel.php';

// Assumindo que você tem uma classe ou função para obter a BASE_URL
if (!defined('BASE_URL')) {
    // Definindo BASE_URL como um fallback ou ajustando conforme a sua arquitetura
    define('BASE_URL', '/'); 
}

// -----------------------------------------------------------------------
// Proteção: Somente POST é permitido
// -----------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'index.php?status=error&msg=Método inválido.'); 
    exit;
}

// Inicializa a variável $action (Padrão: 'create')
$action = $_POST['action'] ?? 'create';

try {
    $categoriamodel = new CategoriaModel();
    $redirect_msg = "Operação concluída."; 
    $redirect_status = "success"; // Status padrão
    $resultado = false;

    // Roteamento de Ações
    switch ($action) {
        
        // =======================================================
        // CASE 'create': INSERIR NOVA CATEGORIA
        // =======================================================
        case 'create':
            $descricao = $_POST['descricao'] ?? '';

            if (empty(trim($descricao))) {
                // Erro de validação: Sai e dispara o redirecionamento de erro no catch, ou centraliza o erro.
                $redirect_status = "error";
                $redirect_msg = "A descrição não pode ser vazia.";
                break;
            }

            $resultado = $categoriamodel->inserir(trim($descricao));
            
            if (!$resultado) {
                $redirect_status = "error";
                $redirect_msg = "Falha ao criar categoria.";
            } else {
                $redirect_msg = "Categoria criada com sucesso.";
            }
            break;

        // =======================================================
        // CASE 'update': ATUALIZAR CATEGORIA EXISTENTE
        // =======================================================
        case 'update':
            $id = $_POST['categoria_id'] ?? null;
            $descricao = $_POST['descricao'] ?? '';

            if (empty($id) || !is_numeric($id) || empty(trim($descricao))) {
                $redirect_status = "error";
                $redirect_msg = "Dados insuficientes ou inválidos para atualização.";
                break;
            }

            $resultado = $categoriamodel->atualizar($id, trim($descricao));

            if (!$resultado) {
                // Não é um erro fatal, mas um aviso
                $redirect_status = "warning";
                $redirect_msg = "Nenhuma alteração detectada ou categoria não encontrada.";
            } else {
                $redirect_msg = "Categoria atualizada com sucesso.";
            }
            break;

        // =======================================================
        // CASE 'delete': EXCLUIR CATEGORIA
        // =======================================================
        case 'delete':
            $id = $_POST['categoria_id'] ?? null;

            if (empty($id) || !is_numeric($id)) {
                $redirect_status = "error";
                $redirect_msg = "ID de categoria inválido para exclusão.";
                break;
            }
            
            $resultado = $categoriamodel->excluir($id);

            if (!$resultado) {
                $redirect_status = "error";
                $redirect_msg = "Falha ao excluir categoria. Verifique dependências.";
            } else {
                $redirect_msg = "Categoria excluída com sucesso.";
            }
            break;

        // =======================================================
        // DEFAULT: Ação inválida
        // =======================================================
        default:
            $redirect_status = "error";
            $redirect_msg = "Ação inválida.";
            break;
    }

    // REDIRECIONAMENTO CENTRALIZADO
    header('Location: ' . BASE_URL . '/view/categoria/index.php?status=' . $redirect_status . '&msg=' . urlencode($redirect_msg));
    exit;

} catch (\Exception $e) {
    // TRATAMENTO CENTRALIZADO DE EXCEÇÃO
    error_log("Erro no CategoriaController: " . $e->getMessage());
    header('Location: ' . BASE_URL . '/view/categoria/index.php?status=error&msg=Erro interno do servidor.');
    exit;
}