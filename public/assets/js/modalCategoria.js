// ----------------------------------------------------------------------------------
// VARIÁVEIS DE ELEMENTOS DO MODAL DE CATEGORIA
// ----------------------------------------------------------------------------------
const categoryModal = document.getElementById('categoryModalOverlay');
const categoryForm = document.getElementById('categoryForm');
const categoryModalTitle = document.getElementById('categoryModalTitle');
const closeCategoryModalBtn = document.getElementById('closeCategoryModal');
const saveCategoryIcon = document.getElementById('saveCategoryIcon');
const submitCategoryForm = document.getElementById('submitCategoryBtn');

// Campos do Formulário (CRÍTICOS para a comunicação com o Controller)
const categoryIDField = document.getElementById('categoryID'); 
const categoryActionField = document.getElementById('categoryAction'); // <--- ESTE ATRIBUTO DEFINE SE É CREATE OU UPDATE
const descricaoField = document.getElementById('descricao_categoria'); 

// CORREÇÃO: Variável ajustada para corresponder ao ID do HTML: 'openCategoryModalBtn'
const openCategoryModalBtn = document.getElementById('openCategoryModalBtn'); 


// ----------------------------------------------------------------------------------
// FUNÇÃO CENTRAL DE ABERTURA E PREPARAÇÃO DO MODAL
// ----------------------------------------------------------------------------------
function prepareAndOpenCategoryModal(mode) {
    // 🛑 1. VERIFICAÇÃO CRÍTICA DO MODAL
    if (!categoryModal || !categoryForm) {
        console.error("ERRO CRÍTICO: O Modal ou Formulário da Categoria não foi encontrado no DOM.");
        return; 
    }
    
    // 2. Limpa e Configura o formulário
    categoryForm.reset();
    
    // 3. Verifica e atribui valores de modo
    if (categoryIDField) categoryIDField.value = '';
    
    // 🔑 PONTO DE CONTROLE: Define a action ('create' ou 'update') para o Controller
    if (categoryActionField) {
        categoryActionField.value = mode; 
    } else {
        console.error("ERRO: Campo 'categoryAction' não encontrado. O Controller não saberá qual ação executar.");
    }
    
    // Define o título do modal
    if (categoryModalTitle) {
        categoryModalTitle.textContent = (mode === 'create') ? 'Nova Categoria' : 'Editar Categoria';
    }

    // 4. ABRE O MODAL
    categoryModal.classList.add('visible');
    console.log(`Modal Categoria aberto no modo: ${mode}. Action set to: ${mode}`); 
}


// ----------------------------------------------------------------------------------
// LISTENERS PARA ABRIR O MODAL
// ----------------------------------------------------------------------------------

// MODO CRIAÇÃO (CREATE): Abre o modal para um novo item (Chama 'create')
// CORREÇÃO: Usando a nova variável 'openCategoryModalBtn'
if (openCategoryModalBtn) {
    openCategoryModalBtn.addEventListener('click', (e) => {
        e.preventDefault();
        prepareAndOpenCategoryModal('create'); // <--- SETA A ACTION = 'create'
        if (descricaoField) {
            descricaoField.focus();
        }
    });
}


// MODO EDIÇÃO (UPDATE): Abre o modal para um item existente (Chama 'update')
document.addEventListener('click', (e) => {
    const button = e.target.closest('.edit-category-btn');

    if (button) {
        e.preventDefault(); 
        console.log("Clique no botão de edição de categoria detectado."); 
        
        // 1. Pega os dados do elemento HTML (vindos do PHP)
        const id = button.dataset.id;
        const descricao = button.dataset.descricao; 
        
        console.log(`Dados capturados - ID: ${id}, Descrição: ${descricao}`);
        
        // 2. Prepara e tenta abrir o modal no modo 'update'
        prepareAndOpenCategoryModal('update'); // <--- SETA A ACTION = 'update'
        
        // 3. Preenche os campos 
        if (categoryIDField && descricaoField) {
            categoryIDField.value = id; 
            descricaoField.value = descricao; 
            descricaoField.focus(); 
        } else {
            console.error("ERRO: Um ou mais campos (categoryID, descricao_categoria) do modal não foram encontrados.");
        }
    }
});


// ----------------------------------------------------------------------------------
// CONTROLES DE FECHAMENTO E SUBMISSÃO
// ----------------------------------------------------------------------------------

function closeCategoryModal() {
    if (categoryModal) {
        categoryModal.classList.remove('visible');
    }
}

// Botão "Sair" do modal
if (closeCategoryModalBtn) {
    closeCategoryModalBtn.addEventListener('click', closeCategoryModal); 
}

// Clique no Overlay escuro
if (categoryModal) {
    categoryModal.addEventListener('click', (e) => {
        if (e.target === categoryModal) {
            closeCategoryModal();
        }
    });
}

// Ligar ÍCONE SALVAR ao FORM SUBMIT
if (saveCategoryIcon && submitCategoryForm) {
    saveCategoryIcon.addEventListener('click', (event) => {
        event.preventDefault(); 
        
        // Log para confirmar a ação que será enviada
        const currentAction = categoryActionField ? categoryActionField.value : 'Ação Desconhecida';
        console.log(`Submit de Categoria disparado! Action final: ${currentAction}`);
        
        // Garante que a validação do HTML é feita antes do submit
        if (categoryForm && categoryForm.checkValidity()) {
            categoryForm.submit(); 
        } else if (categoryForm) {
             // Disparar o clique no submitBtn invisível fará o navegador mostrar o erro de validação
             submitCategoryForm.click();
        }
    });
}