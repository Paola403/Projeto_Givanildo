<?php
// Define o caminho base se você estiver usando uma constante global para o caminho raiz
// Exemplo: define('BASE_URL', '/caminho/do/seu/projeto');

require_once __DIR__ . '/../model/CategoriaModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se não for POST (acesso direto), redireciona para a página principal
    header('Location: ../index.php'); 
    exit;
}

// 1. VERIFICAÇÃO DE SEGURANÇA: Garante que o campo foi enviado
if (isset($_POST['descricao']) && !empty(trim($_POST['descricao']))) {
    
    $descricao = trim($_POST['descricao']);
    
    try {
        $categoriamodel = new CategoriaModel();
        
        // 2. Chama o método de inserção
        $resultado = $categoriamodel->inserir($descricao);
        
        if ($resultado) {
            // SUCESSO: Redireciona de volta com uma flag de sucesso na URL
            // Isso permite que você exiba uma mensagem "Categoria criada!" no index.php
            header('Location: ../index.php?status=success');
            exit;
        } else {
            // FALHA: Redireciona com uma flag de erro
            // O erro aqui pode ser SQL (coluna inexistente, etc.)
            header('Location: ../index.php?status=error&code=db_fail');
            exit;
        }

    } catch (\Exception $e) {
        // EXCEÇÃO: Erro interno (ex: classe CategoriaModel não encontrada)
        error_log("Erro no Controller: " . $e->getMessage());
        header('Location: ../index.php?status=error&code=internal_error');
        exit;
    }

} else {
    // CAMPO VAZIO: Redireciona com um erro específico
    header('Location: ../index.php?status=error&code=empty_field');
    exit;
}