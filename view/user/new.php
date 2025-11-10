<?php
    // Carrega arquivos de configuração e utilidades
    require_once __DIR__ . '/../../config/db.php';
    require_once __DIR__ . '/../../utils/SessionController.php';

    // Se o usuário estiver logado, redireciona para a página principal (boa prática)
    if (SessionController::isLoggedIn()) {
        header("Location: " . BASE_URL . "/index.php"); 
        exit;
    }

    // 1. Obtém os alertas (Flash Messages) da sessão e os limpa
    $alerts = SessionController::getAlerts();
    
    // Mapeamento de tipos de alerta para classes do Tailwind e Ícones Font Awesome
    $alert_config = [
        'error' => [
            'class' => 'bg-red-100 border-red-500 text-red-700',
            'icon' => 'fas fa-times-circle'
        ],
        'warning' => [
            'class' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
            'icon' => 'fas fa-exclamation-triangle'
        ],
        'success' => [
            'class' => 'bg-green-100 border-green-500 text-green-700',
            'icon' => 'fas fa-check-circle'
        ],
    ];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Gerenciador de Tarefas</title>
    <!-- Carrega Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script> 
    <!-- Seus estilos personalizados (se houver) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css"> 
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Apenas garante a fonte */
        body { 
            font-family: 'Inter', sans-serif; 
            /* Importante: Se o seu style.css tiver um background-color no body, 
               ele pode ser substituído pelas classes Tailwind abaixo. */
        }

        /* Estilo do container do formulário */
        .container {
            max-width: 400px;
            width: 90%;
            padding: 2rem;
            background-color: white; /* Fundo do formulário */
            border-radius: 0.5rem;
            /* Adiciona sombra leve */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<!-- 
    Layout da página: 
    - flex, items-center, justify-center: Centraliza o conteúdo.
    - min-h-screen: Garante altura total.
    - bg-gray-50: Define o fundo visível. 
-->
<body class="flex items-center justify-center min-h-screen">
    <main class="container">
        <!-- Ação do formulário deve ir para o controlador de registro -->
        <form action="<?= BASE_URL ?>/controller/RegisterController.php" method="POST">  
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Cadastro</h1>  
            
            <!-- BLOCo DE EXIBIÇÃO DE ALERTAS (Flash Messages) -->
            <?php if (!empty($alerts)): ?>
                <div class="space-y-3 w-full mb-6">
                    <?php 
                        foreach ($alerts as $alert): 
                        $config = $alert_config[$alert['type']] ?? $alert_config['warning'];
                        $style = $config['class'];
                        $icon = $config['icon'];
                    ?>
                        <div class="flex items-start p-4 border-l-4 border-r-4 rounded-lg shadow-md transition-all duration-300 <?= htmlspecialchars($style); ?>" role="alert">
                            
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

            <!-- Campos do Formulário de Cadastro -->
            <div class = "input-box mb-4">
                <input placeholder="Email" type="email" name="email" required class="w-full p-2 border border-gray-300 rounded-md">  
                <i class="fas fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i> 
            </div>
            <div class = "input-box mb-4">
                <input placeholder="Nome" type="text" name="name" required class="w-full p-2 border border-gray-300 rounded-md">  
                <i class="fas fa-user absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i> 
            </div>
            <div class = "input-box mb-4">
                <input placeholder="Senha" type="password" name="password" required class="w-full p-2 border border-gray-300 rounded-md">
                <i class="fas fa-lock absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>    
            </div>
            <div class = "input-box mb-6">
                <input placeholder="Confirme Sua Senha" type="password" name="confirmar_senha" required class="w-full p-2 border border-gray-300 rounded-md">
                <i class="fas fa-lock-open absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>    
            </div>

            <!-- Botão de Cadastro -->
            <button type="submit" class="login w-full py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-200">
                Cadastrar
            </button>
            
            <!-- Link de Login -->
            <div class="register-link mt-6 text-center text-sm text-gray-600">
                <p>Já possui uma conta? <a href="<?= BASE_URL ?>/view/user/index.php" class="text-blue-600 hover:underline font-medium">Clique Aqui!</a></p>
            </div>
        </form>
    </main>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>
</body>
</html>