<?php
require_once __DIR__ . '/../../config/db.php';
?>

<div class="sidebar-menu" id="sidebarMenu">
    
    <i class="fas fa-times close-btn" id="closeMenuBtn"></i>

    <div class="menu-item">
        <i class="fas fa-check-circle finished-icon"></i>
        <span>Listar Tarefas Finalizadas</span>
    </div>

    <div class="menu-item">
        <i class="fas fa-sort-amount-up-alt category-icon"></i>
        <span>Categorias mais Utilizadas</span>
    </div>

    <div class="logout-container">
        <a href="<?= BASE_URL ?>/controller/LogoutController.php" class="logout-link">
            <i class="fas fa-sign-out-alt logout-icon"></i>
            <span>sair</span>
        </a>
    </div>
</div>