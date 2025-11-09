<?php
require_once __DIR__ . '/../config/db.php'; 

require_once __DIR__ . '/SessionController.php'; 

// 2. Inicia a sessão explicitamente (se SessionController::isLoggedIn() não fizer isso)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Sessão</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        pre { background: white; padding: 15px; border: 1px solid #ccc; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h1>📋 Status da Sessão de Usuário</h1>
    <p>URL Base: <strong><?php echo defined('BASE_URL') ? BASE_URL : 'BASE_URL não definida'; ?></strong></p>
    
    <hr>

    <?php if (SessionController::isLoggedIn()): ?>
        
        <p class="success">✅ O usuário está **LOGADO**.</p>
        
        <h2>Dados Armazenados na Sessão:</h2>
        
        <pre>
            <?php
            // Idealmente, seu SessionController deve ter um método para obter o usuário.
            // Aqui, acessamos diretamente a variável $_SESSION que seu SessionController armazena.
            
            // Supondo que o SessionController armazena os dados em $_SESSION['user_data']:
            if (isset($_SESSION['user_data'])) {
                print_r($_SESSION['user_data']);
            } else {
                // Caso o SessionController armazene diretamente na raiz da sessão:
                echo "Variáveis de Sessão (ROOT):\n";
                print_r($_SESSION);
            }
            ?>
        </pre>
        
        <p>
            <a href="<?php echo BASE_URL; ?>/controller/LogoutController.php">Clique aqui para Fazer Logout</a>
        </p>

    <?php else: ?>
        
        <p class="error">❌ O usuário **NÃO** está logado.</p>
        <p>
            <a href="<?php echo BASE_URL; ?>/view/user/index.php">Faça Login para testar</a>
        </p>
        
        <h2>Conteúdo Bruto de $_SESSION:</h2>
        <pre><?php print_r($_SESSION); ?></pre>

    <?php endif; ?>

</body>
</html>