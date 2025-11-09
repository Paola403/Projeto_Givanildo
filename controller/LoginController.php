<?php

require_once __DIR__ . '/../config/db.php'; // Para BASE_URL
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../utils/SessionController.php';

// Inicia a sessão (o SessionController pode já ter feito isso)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se a requisição é um POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/view/user/index.php?error=invalid_request');
    exit;
}

// 1. Recebe e sanitiza os dados do formulário
$login_attempt = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL);
$senha_attempt = $_POST['senha'] ?? ''; // Senha não deve ser sanitizada, apenas validada/verificada

if (empty($login_attempt) || empty($senha_attempt)) {
    header('Location: ' . BASE_URL . '/view/user/index.php?error=empty_fields');
    exit;
}

try {
    $userModel = new UserModel();
    
    // 2. Tenta autenticar o usuário (o UserModel::autenticar já faz o password_verify)
    // O resultado é o array do usuário em caso de sucesso, ou false em caso de falha.
    $user = $userModel->autenticar($login_attempt, $senha_attempt);
    
    if ($user) {
        // 3. AUTENTICAÇÃO BEM-SUCEDIDA: Armazena as informações na sessão
        
        // Colunas da tabela tb_cliente: CLI_ID, CLI_LOGIN, CLI_NOME
        SessionController::login(
            $user['CLI_ID'], 
            $user['CLI_LOGIN'], 
            $user['CLI_NOME']
        );
        
        // 4. Redireciona para a página principal/mural de tarefas
        header('Location: ' . BASE_URL . '/index.php');
        exit;
        
    } else {
        // 5. Autenticação Falhou (Login ou Senha incorretos)
        header('Location: ' . BASE_URL . '/view/user/index.php?error=invalid_credentials');
        exit;
    }

} catch (\Exception $e) {
    // Log de erro interno
    error_log("Erro de Login: " . $e->getMessage());
    header('Location: ' . BASE_URL . '/view/user/index.php?error=internal_error');
    exit;
}