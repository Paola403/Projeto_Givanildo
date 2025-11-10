<?php
    // --- 1. INCLUSÕES E CONFIGURAÇÃO ---
    require_once __DIR__ . '/view/partials/header.php'; // Contém BASE_URL e CSS
    require_once __DIR__ . '/view/partials/sidebar.php';
    require_once __DIR__ . '/utils/SecurityGuard.php';  // Garante que o usuário está logado
    require_once __DIR__ . '/model/CategoriaModel.php'; // Para o modal
    require_once __DIR__ . '/model/TarefaModel.php';    // Para listar tarefas

    $nomeUsuario = SessionController::getNomeUsuario();

    // Busca categorias para o modal (você já tinha isso)
    $categoriaModel = new CategoriaModel();
    $listaCategorias = $categoriaModel->listarTodos();
    
    // --- 2. LÓGICA DE BUSCA E SEPARAÇÃO DE TAREFAS ---
    
    // Pega o ID do usuário logado (pela sessão)
    $cliente_id = SessionController::getIdUsuario();

    // Busca todas as tarefas do cliente no banco
    $tarefaModel = new TarefaModel();
    $todasAsTarefas = $tarefaModel->listarPorCliente($cliente_id);

    // Prepara os arrays para as colunas
    $tarefas_pendentes = [];
    $tarefas_atrasadas = [];
    $hoje = new DateTime('today'); // Pega a data de hoje (à meia-noite)

    // Separa as tarefas
    foreach ($todasAsTarefas as $tarefa) {
        
        // Ignora tarefas que já foram finalizadas
        if ($tarefa['TAREFA_FINALIZADA'] == 1) {
            continue;
        }

        $dataFim = new DateTime($tarefa['TAREFA_DATA_FIM']);
        $dataInicio = new DateTime($tarefa['TAREFA_DATA_INICIO']);

        // Compara a data de término com hoje
        if ($dataFim < $hoje)   {
            // Se a data de término for anterior a hoje, está atrasada
            $tarefas_atrasadas[] = $tarefa;
        } else {
            // Senão, está pendente
            $tarefas_pendentes[] = $tarefa;
        }
    }
?>
       
       <div class="header-content-wrapper">
            <div class="welcome-message">
                <h1>
                    Seja Bem-Vindo(a) À Sua Agenda, 
                    <?php echo htmlspecialchars(ucwords($nomeUsuario)); ?>!
                </h1>
            </div>
        </div>
   
        <div class="main-container">

        <div class="card-column tarefas">
            <h2 class="column-title">Tarefas</h2>
            <hr class="title-divider">

            <?php foreach ($tarefas_pendentes as $tarefa): ?>
                <div class="task-item">
                    <div class="task-info">
                        <span class="task-status-circle"></span>
                        <div class="task-details">
                            <p class="task-title"><?php echo htmlspecialchars($tarefa['TAREFA_TITULO']); ?></p>
                            <span class="task-category"><?php echo htmlspecialchars($tarefa['CATE_DESCRICAO'] ?? 'Sem Categoria'); ?></span>
                            <span class="task-date">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo (new DateTime($tarefa['TAREFA_DATA_FIM']))->format('d/m/y'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="task-actions">
                        <form action="<?= BASE_URL ?>/controller/TarefaController.php" method="POST" class="complete-form">
                        <input type="hidden" name="action" value="complete"> <input type="hidden" name="tarefa_id" value="<?php echo $tarefa['TAREFA_ID']; ?>">
                        <button type="submit" class="complete-btn-submit" title="Finalizar Tarefa">
                            <i class="fas fa-check-circle complete-icon"></i>
                        </button>
                    </form>
                        
                        <i class="fas fa-pencil-alt edit-icon edit-task-btn"
                            data-id="<?php echo $tarefa['TAREFA_ID']; ?>"
                            data-titulo="<?php echo htmlspecialchars($tarefa['TAREFA_TITULO']); ?>"
                            data-descricao="<?php echo htmlspecialchars($tarefa['TAREFA_DESCRICAO']); ?>"
                            data-categoria="<?php echo $tarefa['TAREFA_CATEGORIA']; ?>"
                            data-datainicio="<?php echo substr($tarefa['TAREFA_DATA_INICIO'], 0, 10); ?>"
                            data-datafim="<?php echo substr($tarefa['TAREFA_DATA_FIM'], 0, 10); ?>">                        </i>
                        
                        <form action="<?= BASE_URL ?>/controller/TarefaController.php" method="POST" class="delete-form">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="tarefa_id" value="<?php echo $tarefa['TAREFA_ID']; ?>">
                            <button type="submit" class="delete-btn-submit">
                                <i class="fas fa-times delete-icon"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($tarefas_pendentes)): ?>
                <p class="empty-list-message">Sem tarefas pendentes!</p>
            <?php endif; ?>

            <div class="add-options">
                <p class="add-item" id="openCategoryModalBtn"><i class="fas fa-plus"></i> Categoria</p>
                <p class="add-item" id="openTaskModalBtn"><i class="fas fa-plus"></i> Tarefas</p>
            </div>
        </div>
        
        <div class="card-column atrasados">
            <h2 class="column-title">Atrasados</h2>
            <hr class="title-divider">

            <?php foreach ($tarefas_atrasadas as $tarefa): ?>
                <div class="task-item">
                    <div class="task-info">
                        <span class="task-status-circle"></span>
                        <div class="task-details">
                            <p class="task-title"><?php echo htmlspecialchars($tarefa['TAREFA_TITULO']); ?></p>
                            <span class="task-category"><?php echo htmlspecialchars($tarefa['CATE_DESCRICAO'] ?? 'Sem Categoria'); ?></span>
                            <span class="task-date">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo (new DateTime($tarefa['TAREFA_DATA_FIM']))->format('d/m/y'); ?>
                            </span>
                        </div>
                    </div>
                        <form action="<?= BASE_URL ?>/controller/TarefaController.php" method="POST" class="complete-form">
                        <input type="hidden" name="action" value="complete"> <input type="hidden" name="tarefa_id" value="<?php echo $tarefa['TAREFA_ID']; ?>">
                        <button type="submit" class="complete-btn-submit" title="Finalizar Tarefa">
                            <i class="fas fa-check-circle complete-icon"></i>
                        </button>
                    </form>
                    <div class="task-actions">  
                        <i class="fas fa-pencil-alt edit-icon edit-task-btn"
                            data-id="<?php echo $tarefa['TAREFA_ID']; ?>"
                            data-titulo="<?php echo htmlspecialchars($tarefa['TAREFA_TITULO']); ?>"
                            data-descricao="<?php echo htmlspecialchars($tarefa['TAREFA_DESCRICAO']); ?>"
                            data-categoria="<?php echo $tarefa['TAREFA_CATEGORIA']; ?>"
                            data-datainicio="<?php echo substr($tarefa['TAREFA_DATA_INICIO'], 0, 10); ?>"
                            data-datafim="<?php echo substr($tarefa['TAREFA_DATA_FIM'], 0, 10); ?>"> 
                        </i> 
                        
                        <form action="<?= BASE_URL ?>/controller/TarefaController.php" method="POST" class="delete-form">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="tarefa_id" value="<?php echo $tarefa['TAREFA_ID']; ?>">
                            <button type="submit" class="delete-btn-submit">
                                <i class="fas fa-times delete-icon"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($tarefas_atrasadas)): ?>
                <p class="empty-list-message">Nenhuma tarefa atrasada.</p>
            <?php endif; ?>
        </div>
    </div>

<?php
    // --- 4. INCLUSÃO DOS MODAIS E FOOTER ---
    require_once __DIR__ . '/view/partials/modal/modalCategoria.php';
    require_once __DIR__ . '/view/partials/modal/modalTarefa.php';
    require_once __DIR__ . '/view/partials/footer.php';
?>