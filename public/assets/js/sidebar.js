document.addEventListener('DOMContentLoaded', () => {
    // 1. Obter referências dos elementos
    const openBtn = document.getElementById('openMenuBtn');
    const closeBtn = document.getElementById('closeMenuBtn');
    const sidebar = document.getElementById('sidebarMenu');
    // const mainContent = document.getElementById('mainContent'); // Usado se for mover o conteúdo

    // 2. Função para Abrir o Menu
    const openMenu = () => {
        sidebar.classList.add('active');
        // mainContent.classList.add('shift-content'); // Opcional: Para mover o conteúdo
    };

    // 3. Função para Fechar o Menu
    const closeMenu = () => {
        sidebar.classList.remove('active');
        // mainContent.classList.remove('shift-content'); // Opcional: Para mover o conteúdo
    };

    // 4. Adicionar Listeners de Eventos
    
    // Abrir ao clicar no ícone de barras
    openBtn.addEventListener('click', openMenu);

    // Fechar ao clicar no ícone 'X'
    closeBtn.addEventListener('click', closeMenu);

    // Fechar ao clicar fora do menu (opcional, mas melhora a UX)
    document.addEventListener('click', (event) => {
        // Verifica se o clique foi fora do menu E fora do botão de abrir
        if (!sidebar.contains(event.target) && !openBtn.contains(event.target) && sidebar.classList.contains('active')) {
            closeMenu();
        }
    });
});