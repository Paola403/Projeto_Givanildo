// Adicione as novas variáveis no topo do seu arquivo JS
const categoryModal = document.getElementById('categoryModalOverlay');
const openCategoryBtn = document.querySelector('.add-options .add-item:first-child'); // Seleciona o + Categoria
const closeCategoryModalBtn = document.getElementById('closeCategoryModal');

// ✅ AGORA: Busca o ícone de disquete pelo seu ID correto (dentro do input)
const saveCategoryIcon = document.getElementById('saveCategoryIcon'); 
const submitCategoryForm = document.getElementById('submitCategoryBtn'); // Botão invisível do form

// --- Funções do Modal ---

// 1. ABRIR MODAL
if (openCategoryBtn) {
    openCategoryBtn.addEventListener('click', () => {
        categoryModal.classList.add('visible');
    });
}

// 2. FECHAR MODAL (Clicando no botão 'Sair')
if (closeCategoryModalBtn) {
    closeCategoryModalBtn.addEventListener('click', () => {
        categoryModal.classList.remove('visible');
    });
}

// 3. FECHAR MODAL (Clicando no overlay escuro)
if (categoryModal) {
    categoryModal.addEventListener('click', (e) => {
        // Verifica se o clique foi no overlay e não no conteúdo
        if (e.target === categoryModal) {
            categoryModal.classList.remove('visible');
        }
    });
}

// 4. LIGAR ÍCONE SALVAR ao FORM SUBMIT
// Usa o nome da variável corrigido: saveCategoryIcon
if (saveCategoryIcon && submitCategoryForm) {
    saveCategoryIcon.addEventListener('click', (event) => {
        
        // Adicionando preventDefault para garantir que o ícone não execute nenhuma ação padrão,
        // apenas dispare o submit do formulário.
        event.preventDefault(); 

        console.log("Submit disparado pelo ícone de salvar (JS OK)!"); // Linha de debug
        
        // Dispara o botão de submit real do formulário
        submitCategoryForm.click();
    });
}