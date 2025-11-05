<div class="modal-overlay" id="categoryModalOverlay">
    <div class="modal-content">
        
        <div class="modal-header">
            <h2 class="modal-title">Categoria</h2>
            
            <button class="modal-close-btn" id="closeCategoryModal">
                <span class="close-text">Sair</span>
                <i class="fas fa-sign-out-alt close-icon"></i>
            </button>
        </div>

        <form id="categoryForm" action="<?= BASE_URL ?>/controller/CategoriaController.php" method="POST">
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" name="descricao" placeholder="Descrição" required>
                    <i class="fas fa-save save-in-input-icon" id="saveCategoryIcon"></i>
                </div>
            </div>
            
            <button type="submit" style="display: none;" id="submitCategoryBtn"></button>
        </form>
    </div>
</div>