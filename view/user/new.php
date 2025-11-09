<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../utils/SessionController.php';
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
<body>
    <main class="container">
        <form action="<?= BASE_URL ?>/controller/UserController.php" method="post">
                <h1>Cadastro</h1>
                <div class = "input-box">
                    <input placeholder="Email" type="email" name="email">  
                    <i class="bx bxs-user"></i> 
                </div>
                <div class = "input-box">
                    <input placeholder="Nome" type="name" name="name">  
                    <i class="bx bxs-user"></i> 
                </div>
                <div class = "input-box">
                    <input placeholder="Senha" type="password" name="password">
                    <i class="bx bxs-lock-alt"></i>    
                </div>
                <div class = "input-box">
                    <input placeholder="Confirme Sua Senha:" type="password" name="confirmar_senha">
                    <i class="bx bxs-lock-alt"></i>    
                </div>

                <div class="remember-forgot">
                    <label>
                    <input type="checkbox">
                    Lembrar Senha
                    </label>
                    <a href="#">Esqueci minha Senha</a>
                </div>

                <button type="submit" class="login">Cadastrar</button>


        </form>
    </main>

<?php
    require_once __DIR__ . '/../partials/footer.php';
?>
