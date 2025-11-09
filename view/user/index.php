<?php
    require_once __DIR__ . '/../../config/db.php';
    require_once __DIR__ . '/../../utils/SessionController.php';

    if (SessionController::isLoggedIn()) {
        header("Location: " . BASE_URL . "/index.php"); 
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
    <body class="login-page"><main class="container">
                <form action="<?= BASE_URL ?>/controller/LoginController.php" method="POST">
                <h1>Login</h1>  
                <div class = "input-box">
                    <input placeholder="Email" type="email" name="login" required>  
                    <i class="fas fa-user"></i> 
                </div>
                <div class = "input-box">
                    <input placeholder="Senha" type="password" name="senha" required>
                    <i class="fas fa-lock"></i>    
                </div>

                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember">
                            Lembrar Senha
                        </label>
                    <a href="#">Esqueci minha Senha</a>
                </div>

                <button type="submit" class="login">Login</button>

                <div class="register-link">
                    <p>Não tem uma Conta? <a href="<?= BASE_URL ?>/view/user/new.php"> Cadastrar-se</a></p>
                </div>
        </form>
    </main>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>