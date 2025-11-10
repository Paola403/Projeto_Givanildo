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
    // Define o alerta e redireciona
    SessionController::setAlert('error', 'Método de requisição inválido.');
    header('Location: ' . BASE_URL . '/view/user/index.php');
    exit;
}

// 1. Recebe e sanitiza os dados do formulário
$login_attempt = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL);
$senha_attempt = $_POST['senha'] ?? ''; // Senha não deve ser sanitizada

if (empty($login_attempt) || empty($senha_attempt)) {
    // Define o alerta e redireciona
    SessionController::setAlert('warning', 'Por favor, preencha todos os campos (Login e Senha).');
    header('Location: ' . BASE_URL . '/view/user/index.php');
    exit;
}

try {
    $userModel = new UserModel();
    
    // 2. Tenta autenticar o usuário
    $user = $userModel->autenticar($login_attempt, $senha_attempt);
    
    if ($user) {
        // 3. AUTENTICAÇÃO BEM-SUCEDIDA: Armazena as informações na sessão
        
        // Colunas da tabela tb_cliente: CLI_ID, CLI_LOGIN, CLI_NOME
        SessionController::login(
            $user['CLI_ID'], 
            $user['CLI_LOGIN'], 
            $user['CLI_NOME']
        );
        
        // 4. Redireciona para a página principal
        header('Location: ' . BASE_URL . '/index.php');
        exit;
        
    } else {
        // 5. Autenticação Falhou (Login ou Senha incorretos)
        // Define o alerta e redireciona
        SessionController::setAlert('error', 'Login ou Senha incorretos. Tente novamente.');
        header('Location: ' . BASE_URL . '/view/user/index.php');
        exit;
    }

} catch (\Exception $e) {
    // Log de erro interno
    error_log("Erro de Login: " . $e->getMessage());
    // Define o alerta de erro interno e redireciona
    SessionController::setAlert('error', 'Ocorreu um erro interno. Tente novamente mais tarde.');
    header('Location: ' . BASE_URL . '/view/user/index.php');
    exit;
}