    <?php
        require_once __DIR__ . '/view/partials/header.php';
        require_once __DIR__ . '/view/partials/sidebar.php';
    ?>
    <div class="main-container">

        <div class="card-column tarefas">
            <h2 class="column-title">Tarefas</h2>
            <hr class="title-divider">

            <?php // foreach ($tarefas_pendentes as $tarefa): ?> 

            <div class="task-item">
                <div class="task-info">
                    <span class="task-status-circle"></span> <div class="task-details">
                        <p class="task-title">Dever de Casa</p> <span class="task-category">Escola</span> <span class="task-date"><i class="far fa-calendar-alt"></i> 31/08/25</span> </div>
                </div>
                <div class="task-actions">
                    <i class="fas fa-pencil-alt edit-icon"></i> <i class="fas fa-times delete-icon"></i> </div>
            </div>

            <div class="task-item">
                <div class="task-info">
                    <span class="task-status-circle"></span>
                    <div class="task-details">
                        <p class="task-title">Relatório de Vendas</p>
                        <span class="task-category">Trabalho</span>
                        <span class="task-date"><i class="far fa-calendar-alt"></i> 31/08/25</span>
                    </div>
                </div>
                <div class="task-actions">
                    <i class="fas fa-pencil-alt edit-icon"></i>
                    <i class="fas fa-times delete-icon"></i>
                </div>
            </div>
            <?php // endforeach; ?>
            <div class="add-options">
                <p class="add-item"><i class="fas fa-plus"></i> Categoria</p>
                <p class="add-item"><i class="fas fa-plus"></i> Tarefas</p>
                <p class="add-item"><i class="fas fa-chevron-up"></i> Adicionar Item</p> </div>
        </div>
        
        <div class="card-column atrasados">
            <h2 class="column-title">Atrasados</h2>
            <hr class="title-divider">

            <?php // foreach ($tarefas_atrasadas as $tarefa): ?> 

            <div class="task-item">
                <div class="task-info">
                    <span class="task-status-circle"></span>
                    <div class="task-details">
                        <p class="task-title">Óleo Carro</p>
                        <span class="task-category">Carro</span>
                        <span class="task-date"><i class="far fa-calendar-alt"></i> 30/08/25</span>
                    </div>
                </div>
                <div class="task-actions">
                    <i class="fas fa-pencil-alt edit-icon"></i>
                    <i class="fas fa-times delete-icon"></i>
                </div>
            </div>
            
            <?php // endforeach; ?>
            </div>
    </div>
<?php
    require_once __DIR__ . '/view/partials/modalCategoria.php';
    require_once __DIR__ . '/view/partials/footer.php';
?>