<?php
require_once __DIR__ ."../../modal/modalTarefa.php";                

?>
<div class="modal-overlay" id="taskModalOverlay">
    <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="modal-save-btn" id="saveTaskIcon">
                <i class="fas fa-save save-icon"></i>
                <span class="save-text">Salvar</span>
            </button>
            
            <h2 class="modal-title">Tarefas</h2>
            
            <button class="modal-close-btn" id="closeTaskModal">
                <span class="close-text">Sair</span>
                <i class="fas fa-sign-out-alt close-icon"></i>
            </button>
        </div>

        <form id="taskForm" action="<?= BASE_URL ?>/controller/TarefaController.php" method="POST">
            
            <input type="hidden" name="action" id="taskAction" value="create">
            <input type="hidden" name="tarefa_id" id="taskID" value="">

            <div class="modal-body task-modal-body">
                
        <div class="input-full-width">
                    <input type="text" name="titulo" placeholder="Título" required>
                </div>
                
                <div class="input-select-group">
                    <select name="categoria_id" required>
                        <option value="" disabled selected>Categoria</option>
            
                        <?php 
                        // Loop PHP para preencher as categorias
                        if (isset($listaCategorias) && !empty($listaCategorias)) {
                            foreach ($listaCategorias as $categoria) {
                                // Assume que sua tabela Categoria tem CATE_ID e CATE_DESCRICAO
                                echo "<option value=\"{$categoria['CATE_ID']}\">" 
                                . htmlspecialchars(string: ucwords($categoria['CATE_DESCRICAO'])) 
                                . "</option>";
                            }
                        } else {
                            echo "<option value=\"\" disabled>Nenhuma categoria encontrada</option>";
                        }
                        ?>

                    </select>
                </div>
                
                <div class="input-row">
                    
                    <div class="input-date-group">
                        <label for="data_inicio">Início:</label>
                        <input type="date" name="data_inicio" id="data_inicio" required>
                    </div>

                    <div class="input-date-group">
                        <label for="data_fim">Fim:</label>
                        <input type="date" name="data_fim" id="data_fim" required>
                    </div>
                </div>

                <div class="input-full-width description-area">
                    <textarea name="descricao" placeholder="Descrição"></textarea>
                </div>
            </div>
            
            <button type="submit" style="display: none;" id="submitTaskBtn"></button>
        </form>
    </div>
</div>