<?php

require_once __DIR__ . '/../config/db.php'; // Para BASE_URL
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../utils/SessionController.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nome  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $login = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['password'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    if (empty($nome) || empty($login) || empty($senha) || empty($confirmar_senha)) {
        header('Location: ' . BASE_URL . '/view/user/new.php?error=empty_fields');
        exit;
    }

    if ($senha !== $confirmar_senha) {
        header('Location: ' . BASE_URL . '/view/user/new.php?error=password_mismatch');
        exit;
    }
    
    $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
    
    try {
        $userModel = new UserModel();
        
        if ($userModel->buscarPorLogin($login)) {
             header('Location: ' . BASE_URL . '/view/user/new.php?error=user_exists');
             exit;
        }

        if ($userModel->inserir($nome, $login, $senha_hashed)) {
            
            header('Location: ' . BASE_URL . '/view/user/index.php?status=registered');
            exit;
        } else {
            // Falha na inserção SQL
            header('Location: ' . BASE_URL . '/view/user/new.php?error=db_insert_failed');
            exit;
        }

    } catch (\Exception $e) {
        error_log("Erro no registro: " . $e->getMessage());
        header('Location: ' . BASE_URL . '/view/user/new.php?error=internal_error');
        exit;
    }

} else {
    header('Location: ' . BASE_URL . '/view/user/new.php');
    exit;
}