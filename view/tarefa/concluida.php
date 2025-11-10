<?php
    // --- 1. INCLUSÕES E CONFIGURAÇÃO ---
    require_once __DIR__ . '/../../view/partials/header.php';
    require_once __DIR__ . '/../../view/partials/sidebar.php';
    require_once __DIR__ . '/../../utils/SecurityGuard.php'; 
    require_once __DIR__ . '/../../model/CategoriaModel.php';
    require_once __DIR__ . '/../../model/TarefaModel.php';

    $nomeUsuario = SessionController::getNomeUsuario();

    // Busca categorias para o modal (você já tinha isso)
    $categoriaModel = new CategoriaModel();
    $listaCategorias = $categoriaModel->listarTodos();
    
    // --- 2. LÓGICA DE BUSCA E FILTRAGEM DE TAREFAS ---
    
    // Pega o ID do usuário logado (pela sessão)
    $cliente_id = SessionController::getIdUsuario();

    // Busca todas as tarefas do cliente no banco
    $tarefaModel = new TarefaModel();
    $todasAsTarefas = $tarefaModel->listarPorCliente($cliente_id);

    // Prepara o array para a lista de Finalizadas
    $tarefas_finalizadas = []; 
    // $tarefas_pendentes e $tarefas_atrasadas não são mais necessários nesta lógica

    // Separa as tarefas, pegando apenas as com status 'F'
    foreach ($todasAsTarefas as $tarefa) {
        
        // NOVO FILTRO: Apenas tarefas com TAREFA_STATUS = 'F'
        if ($tarefa['TAREFA_STATUS'] === 'F') {
            $tarefas_finalizadas[] = $tarefa;
        }
        
        // A lógica anterior de data/atraso foi removida, pois só queremos finalizadas
    }
?>
       
       <div class="header-content-wrapper">
            <div class="welcome-message">
                <h1>
                    Parabéns Por Completar Suas Tarefas, Continue Assim!
                </h1>
            </div>
        </div>
        
            <div class="main-container">

            <div class="card-column tarefas">
                <h2 class="column-title">Tarefas Finalizadas</h2> 
                <hr class="title-divider">

                <?php foreach ($tarefas_finalizadas as $tarefa): ?>
                    <div class="task-item">
                        <div class="task-info">
                            <span class="task-status-circle finished"></span> 
                            <div class="task-details">
                                <p class="task-title"><?php echo htmlspecialchars($tarefa['TAREFA_TITULO']); ?></p>
                                <span class="task-category"><?php echo htmlspecialchars($tarefa['CATE_DESCRICAO'] ?? 'Sem Categoria'); ?></span>
                                <span class="task-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo (new DateTime($tarefa['TAREFA_DATA_FINALIZADA']))->format('d/m/y'); ?>
                                </span>
                            </div>
                        </div>
                        </div>
                <?php endforeach; ?>
            </div>
            
            </div>

<?php
    // --- 4. INCLUSÃO DOS MODAIS E FOOTER ---
    // ...

    // --- 4. INCLUSÃO DOS MODAIS E FOOTER ---
    require_once __DIR__ . '/../../view/partials/modal/modalCategoria.php';
    require_once __DIR__ . '/../../view/partials/modal/modalTarefa.php';
    require_once __DIR__ . '/../../view/partials/footer.php';
?>