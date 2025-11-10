<?php
    // Carrega arquivos de configuração e utilidades
    require_once __DIR__ . '/../../config/db.php';
    require_once __DIR__ . '/../../utils/SessionController.php';

    // Se o usuário estiver logado, redireciona para a página principal
    if (SessionController::isLoggedIn()) {
        header("Location: " . BASE_URL . "/index.php"); 
        exit;
    }

    // Obtém os alertas (Flash Messages) da sessão e os limpa
    $alerts = SessionController::getAlerts();
    
    // Mapeamento de tipos de alerta para classes do Tailwind e Ícones Font Awesome
    $alert_config = [
        'error' => [
            'class' => 'bg-red-100 border-red-500 text-red-700',
            'icon' => 'fas fa-times-circle' // Ícone de erro
        ],
        'warning' => [
            'class' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
            'icon' => 'fas fa-exclamation-triangle' // Ícone de aviso
        ],
        'success' => [
            'class' => 'bg-green-100 border-green-500 text-green-700',
            'icon' => 'fas fa-check-circle' // Ícone de sucesso
        ],
    ];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gerenciador de Tarefas</title>
    <!-- 
        MANDATÓRIO: Carrega Tailwind CSS via CDN para que as classes de estilo (ex: bg-red-100) funcionem 
        no bloco de alerta. Se o seu projeto usa um arquivo CSS compilado do Tailwind, essa linha não seria necessária.
    -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Seus estilos personalizados (como .login-page, .container, .input-box) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css"> 
    <!-- Font Awesome para os ícones dos alertas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Garantindo que o Tailwind use uma fonte comum */
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="login-page">
    <main class="container">
        <form action="<?= BASE_URL ?>/controller/LoginController.php" method="POST">
            <h1>Login</h1>  
            
            <!-- BLOCo DE EXIBIÇÃO DE ALERTAS (Flash Messages) -->
            <?php if (!empty($alerts)): ?>
                <div class="space-y-3 w-full mb-6">
                    <?php 
                        foreach ($alerts as $alert): 
                        // Obtém a configuração de estilo/ícone, ou usa o warning como fallback
                        $config = $alert_config[$alert['type']] ?? $alert_config['warning'];
                        $style = $config['class'];
                        $icon = $config['icon'];
                    ?>
                        <!-- 
                            Alerta Amigável: 
                            1. Usa 'flex items-start' para alinhar ícone e texto.
                            2. Usa a classe $style para as cores (ex: bg-red-100 border-red-500).
                            3. Removeu a linha que mostrava o texto $alert['type'].
                        -->
                        <div class="flex items-start p-4 border-l-4 rounded-lg shadow-md transition-all duration-300 <?= htmlspecialchars($style); ?>" role="alert">
                            
                            <!-- Ícone -->
                            <i class="<?= htmlspecialchars($icon); ?> text-lg mr-3 mt-0.5 flex-shrink-0"></i>

                            <!-- Mensagem -->
                            <p class="font-medium flex-grow">
                                <?= htmlspecialchars($alert['message']); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <!-- FIM DO BLOCO DE ALERTAS -->

            <div class = "input-box">
                <input placeholder="Email" type="text" name="login" required>  
                <i class="fas fa-user"></i> 
            </div>
            <div class = "input-box">
                <input placeholder="Senha" type="password" name="senha" required>
                <i class="fas fa-lock"></i>    
            </div>

            <!-- Botões e Links -->
            <button type="submit" class="login">Login</button>

            <div class="register-link">
                <p>Não tem uma Conta? <a href="<?= BASE_URL ?>/view/user/new.php"> Cadastrar-se</a></p>
            </div>
        </form>
    </main>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>
</body>
</html>