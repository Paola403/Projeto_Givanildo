// Localize as variáveis no topo do seu menu.js
const taskModal = document.getElementById('taskModalOverlay');
const taskForm = document.getElementById('taskForm'); // Adicionando o form ID para reset
const taskModalTitle = document.getElementById('taskModalTitle'); // Assumindo que você tem um H1/H2 com este ID no modal
const openTaskBtn = document.querySelector('.add-options .add-item:nth-child(2)'); 
const closeTaskModalBtn = document.getElementById('closeTaskModal');
const saveTaskIcon = document.getElementById('saveTaskIcon'); 
const submitTaskForm = document.getElementById('submitTaskBtn');
const dataInicioField = document.getElementById('data_inicio');
const dataFimField = document.getElementById('data_fim');

// --- FUNÇÃO AUXILIAR: Obtém a data de hoje no formato YYYY-MM-DD ---
function getTodayDateString() {
    const today = new Date();
    // Obtém a data no formato 'YYYY-MM-DD'
    return today.toISOString().slice(0, 10);
}

// Botões de edição (o ícone de lápis)
const editButtons = document.querySelectorAll('.edit-task-btn'); 

// --- FUNÇÕES DE CONTROLE DO MODAL ---

/**
 * Função central para limpar e abrir o modal no modo desejado.
 * @param {string} mode 'create' ou 'update'
 */
function prepareAndOpenTaskModal(mode) {
    // 1. Limpa todos os campos e o ID da tarefa
    taskForm.reset();
    document.getElementById('taskID').value = '';
    
    // 2. Define a ação de envio do formulário
    document.getElementById('taskAction').value = mode;

    // 3. Define o título do modal
    if (taskModalTitle) {
        taskModalTitle.textContent = (mode === 'create') ? 'Nova Tarefa' : 'Editar Tarefa';
    }

    // 🔑 NOVO CÓDIGO AQUI: Preenchimento automático de data, SÓ no modo 'create'
    if (mode === 'create') {
        const today = getTodayDateString(); 
        
        if (dataInicioField) {
            dataInicioField.value = today; 
        }
        
        if (dataFimField) {
            dataFimField.value = today; 
        }
    }

    // 4. Torna o modal visível
    taskModal.classList.add('visible');
}

/**
 * Fecha o modal
 */
function closeTaskModal() {
    taskModal.classList.remove('visible');
}


// --- 1. CONFIGURAÇÃO DO MODO CRIAÇÃO (Botão "+ Tarefas") ---

if (openTaskBtn && taskModal) {
    openTaskBtn.addEventListener('click', () => {
        // Prepara e abre no modo "create"
        prepareAndOpenTaskModal('create');
        
    });
}


// --- 2. CONFIGURAÇÃO DO MODO EDIÇÃO (Botão Lápis) ---

editButtons.forEach(button => {
    button.addEventListener('click', () => {
        // 1. Pega os dados dos atributos data-*
        const id = button.dataset.id;
        const titulo = button.dataset.titulo;
        const categoria = button.dataset.categoria;
        const descricao = button.dataset.descricao;
        const dataInicio = button.dataset.datainicio;
        const dataFim = button.dataset.datafim;

        // 2. Prepara o modal (define 'update' e limpa o ID)
        prepareAndOpenTaskModal('update');
        
        // 3. Preenche os campos com os dados da tarefa
        document.getElementById('taskID').value = id; // Define o ID para o update

        // Preenchimento dos campos do formulário
        document.querySelector('#taskForm input[name="titulo"]').value = titulo;
        document.querySelector('#taskForm select[name="categoria_id"]').value = categoria;
        document.querySelector('#taskForm textarea[name="descricao"]').value = descricao;
        document.querySelector('#taskForm input[name="data_inicio"]').value = dataInicio;
        document.querySelector('#taskForm input[name="data_fim"]').value = dataFim;
    });
});


// --- 3. CONTROLES DE FECHAMENTO DO MODAL ---

// Botão "Sair"
if (closeTaskModalBtn) {
    closeTaskModalBtn.addEventListener('click', closeTaskModal); 
}

// Clique no Overlay escuro
if (taskModal) {
    taskModal.addEventListener('click', (e) => {
        if (e.target === taskModal) {
            closeTaskModal();
        }
    });
}


// --- 4. LIGAR ÍCONE SALVAR ao FORM SUBMIT ---

// O ícone "Salvar" no modal atua como um trigger para o botão submit real do formulário
if (saveTaskIcon && submitTaskForm) {
    saveTaskIcon.addEventListener('click', (event) => {
        event.preventDefault(); 
        console.log("Submit de Tarefa disparado!");
        submitTaskForm.click(); // Dispara o clique no <button type="submit" id="submitTaskBtn">
    });
}