<?php
require_once __DIR__ . '/../../config/db.php';
?>

<div id="sidebarOverlay" class="sidebar-overlay">

    <div class="sidebar-menu" id="sidebarMenu">
        
        <i class="fas fa-times close-btn" id="closeMenuBtn"></i>

        <a href="<?= BASE_URL ?>/index.php" >
            <div class="menu-item">
                <i class="fas fa-home home-icon"></i> <span>Página Inicial</span>
            </div>
        </a>
    
        <a href="<?= BASE_URL ?>/view/tarefa/concluida.php" >
            <div class="menu-item">
                <i class="fas fa-check-circle finished-icon"></i>
                <span>Listar Tarefas Finalizadas</span>
            </div>
        </a>

        <a href="<?= BASE_URL ?>/view/categoria/index.php" >
            <div class="menu-item">
                <i class="fas fa-sort-amount-up-alt category-icon"></i>
                <span>Categorias Mais utilizadas</span>
            </div>
        </a>

        <a href="<?= BASE_URL ?>/view/user/edit.php" >
            <div class="menu-item">
                <i class="fas fa-user-circle"></i>
                <span>Alterar Informação</span>
            </div>
        </a>


        <div class="logout-container">
            <a href="<?= BASE_URL ?>/controller/LogoutController.php" class="logout-link">
                <i class="fas fa-sign-out-alt logout-icon"></i>
                <span>sair</span>
            </a>
        </div>
    </div>
</div>