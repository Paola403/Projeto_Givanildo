<?php
// controllers/LogoutController.php

// ATENÇÃO: Verifique se este caminho está correto para o seu arquivo de configuração
require_once __DIR__ . '/../config/db.php'; 
require_once __DIR__ . '/../utils/SessionController.php';

// O código PHP DEVE COMEÇAR IMEDIATAMENTE APÓS A TAG DE ABERTURA <?php 
// SEM NENHUM ESPAÇO, NOVA LINHA, OU CARACTERE ANTES.

// 1. Inicia a sessão se ela ainda não estiver ativa (Geralmente SessionController faz isso)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. Chama o método de logout para limpar e destruir a sessão
SessionController::logout();

header('Location: ' . BASE_URL . '/view/user/index.php?status=logged_out');

// 4. ESSENCIAL: Interrompe a execução do script imediatamente
exit; 

// Fim do arquivo