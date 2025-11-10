<?php
    // --- 1. INCLUSÕES E CONFIGURAÇÃO ---
    require_once __DIR__ . '/../../view/partials/header.php';
    require_once __DIR__ . '/../../view/partials/sidebar.php';
    require_once __DIR__ . '/../../utils/SecurityGuard.php'; 
    require_once __DIR__ . '/../../model/CategoriaModel.php';
    require_once __DIR__ . '/../../model/TarefaModel.php';

    $nomeUsuario = SessionController::getNomeUsuario();

    // Busca categorias para o modal
    $categoriaModel = new CategoriaModel();
    $listaCategorias = $categoriaModel->listarTodos();
    
    // --- 2. LÓGICA DE BUSCA E FILTRAGEM DE TAREFAS ---
    
    // Pega o ID do usuário logado (pela sessão)
    $cliente_id = SessionController::getIdUsuario();

    $tarefaModel = new TarefaModel();
    $categoriasMaisUsadas = $tarefaModel->listarCategoriasMaisUsadas($cliente_id);

?>
        
        <div class="header-content-wrapper">
            <div class="welcome-message">
                <h1>
                    Aqui Estão Suas Categorias Mais Utilizadas!
                </h1>
            </div>
        </div>

        <div class="main-container" id="category-main-container">

            <div class="card-column tarefas">
                <h2 class="column-title">Categorias Mais Usadas</h2> 
                <hr class="title-divider">

                <?php foreach ($categoriasMaisUsadas as $categoria): ?>
                    <div class="task-item">
                        <div class="task-info" style="justify-content: space-between;"> 
                            
                            <div class="task-details">
                                <p class="task-title">
                                    <?php echo htmlspecialchars(ucwords($categoria['CATE_DESCRICAO'])); ?>
                                </p>
                            </div>
                            
                            <span class="category-count">
                                <?php 
                                $total_usos = $categoria['total_usos'];
                                if ($total_usos == 1) {
                                    echo $total_usos . ' Vez';
                                } else {
                                    echo $total_usos . ' Vezes';
                                }
                                ?>
                            </span>
                            
                            <div class="task-actions category-actions">
                                
                                <i class="fas fa-pencil-alt edit-icon edit-category-btn"
                                    data-id="<?php echo $categoria['CATE_ID']; ?>"
                                    data-descricao="<?php echo htmlspecialchars($categoria['CATE_DESCRICAO']); ?>"
                                    title="Editar Categoria">
                                </i>
                                
                                <form action="<?= BASE_URL ?>/controller/CategoriaController.php" method="POST" class="delete-category-form" onsubmit="return confirm('Tem certeza que deseja excluir a categoria: <?php echo addslashes($categoria['CATE_DESCRICAO']); ?>? Todas as tarefas associadas a ela ficarão sem categoria.');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="categoria_id" value="<?php echo $categoria['CATE_ID']; ?>">
                                    <button type="submit" class="delete-btn-submit" title="Excluir Categoria">
                                        <i class="fas fa-times delete-icon"></i>
                                    </button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <?php if (empty($categoriasMaisUsadas)): ?>
                    <p style="text-align: center; margin-top: 20px;">
                        Nenhuma categoria encontrada ou utilizada em tarefas.
                    </p>
                <?php endif; ?>

            </div>
        </div>

<?php
    // Inclui a estrutura do modal
    require_once __DIR__ . '/../../view/partials/modal/modalCategoria.php';
    require_once __DIR__ . '/../partials/footer.php';
?>