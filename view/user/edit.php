<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../utils/SessionController.php';
require_once __DIR__ . '/../../model/UserModel.php';
require_once __DIR__ . '/../../utils/SecurityGuard.php'; 

$idUsuario = SessionController::getIdUsuario();
$userModel = new UserModel();
$UserID = $userModel->buscarPorId($idUsuario);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Cadastro</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <main class="container">
        <form action="<?= BASE_URL ?>/controller/UserController.php" method="post">
                <h1>Atualizar Cadastro</h1>
                
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($UserID['CLI_ID']) ?? '' ?>">

                <div class = "input-box">
                    <input placeholder="Email" type="email" name="email" value="<?= htmlspecialchars($UserID['CLI_LOGIN']) ?? '' ?>">  
                    <i class="bx bxs-user"></i> 
                </div>
                <div class = "input-box">
                    <input placeholder="Nome" type="name" name="name" value="<?= htmlspecialchars($UserID['CLI_NOME']) ?? '' ?>">  
                    <i class="bx bxs-user"></i> 
                </div>

                <button type="submit" class="login">Alterar</button>
                <div class="register-link mt-6 text-center text-sm text-gray-600">
                <p>Está no lugar errado? Clique <a href="<?= BASE_URL ?>/index.php" class="text-blue-600 hover:underline font-medium">Aqui!</a></p><p>Para Voltar</p>  
            </div>

        </form>
    </main>

<?php
    require_once __DIR__ . '/../partials/footer.php';
?>