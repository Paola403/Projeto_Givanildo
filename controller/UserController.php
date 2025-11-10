<?php
// Define o caminho base e carrega dependências
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../utils/SessionController.php'; // Mantido, mas não usado para mensagens neste modo

// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. Definição das URLs de redirecionamento (Certifique-se de que BASE_URL está correto)
$redirect_new = BASE_URL . '/view/user/new.php'; // Cadastro
$redirect_edit = BASE_URL . '/view/user/edit.php'; // Edição de perfil
$redirect_login = BASE_URL . '/view/user/index.php'; // Login/Index

/**
 * Função auxiliar para adicionar o código de erro à URL e redirecionar.
 * @param string $url A URL base.
 * @param string $errorCode O código de erro a ser anexado.
 */
function redirectToError(string $url, string $errorCode): void {
    $redirect_url = $url . '?error=' . urlencode($errorCode);
    header('Location: ' . $redirect_url);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. Coleta e sanitização de dados
    // CORREÇÃO: Removida a concatenação errada no filter_input
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'insert';
    
    $nome = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    $login = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
    $senha = $_POST['password'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    $erros_encontrados = false;
    
    // Instancia o modelo
    $userModel = new UserModel();

    switch ($action) {
        
        case 'update':
            // LÓGICA DE ATUALIZAÇÃO (EDIÇÃO DE PERFIL)

            // Coleta o ID do usuário (campo hidden)
            $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
            $redirect_location = $redirect_edit; // Em caso de erro, volta para a edição
            
            // LOG DE DIAGNÓSTICO
            error_log("ID recebido na atualização: " . var_export($id_usuario, true));

            // 1. Validação CRÍTICA de ID (Se falhar, redireciona para o login)
            if (!$id_usuario) {
                // ERRO: ID_INVALIDO -> O formulário não enviou o ID corretamente
                redirectToError($redirect_login, 'ID_INVALIDO'); 
            }

            // 2. Validação de campos obrigatórios (Nome e Email)
            if (empty($nome) || empty($login)) {
                // ERRO: CAMPOS_VAZIOS
                redirectToError($redirect_location, 'CAMPOS_VAZIOS');
            }

            // 3. Validação do formato do Email
            if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
                // ERRO: EMAIL_INVALIDO
                redirectToError($redirect_location, 'EMAIL_INVALIDO');
            }

            // 4. Validação de senhas (Opcional na atualização)
            $senha_para_atualizar = null; 

            if (!empty($senha) || !empty($confirmar_senha)) {
                if ($senha !== $confirmar_senha) {
                    // ERRO: SENHAS_DIFERENTES
                    redirectToError($redirect_location, 'SENHAS_DIFERENTES');
                }
                // Senhas OK, preparar para hash
                $senha_para_atualizar = password_hash($senha, PASSWORD_DEFAULT);
            }
            
            // 5. Lógica de Banco de Dados para Atualização
            try {
                // Verifica se o novo login já pertence a OUTRO usuário (e não a ele mesmo)
                $userByLogin = $userModel->buscarPorLogin($login);
                if ($userByLogin && $userByLogin['id'] != $id_usuario) {
                    // ERRO: EMAIL_EXISTENTE
                    redirectToError($redirect_location, 'EMAIL_EXISTENTE');
                }
                
                // Chamada ao método de atualização no Model
                if ($userModel->atualizar($id_usuario, $nome, $login, $senha_para_atualizar)) {
                    // SUCESSO
                    header('Location: ' . $redirect_location . '?status=SUCESSO'); 
                    exit;
                } else {
                    // ERRO: NENHUMA_ALTERACAO -> Query rodou, mas não afetou linhas (Model falhou)
                    redirectToError($redirect_location, 'NENHUMA_ALTERACAO');
                }
            } catch (\Exception $e) {
                error_log("Erro na atualização (Exceção): " . $e->getMessage());
                // ERRO: ERRO_INTERNO_DB
                redirectToError($redirect_location, 'ERRO_INTERNO_DB');
            }

            break;

        case 'insert':
        default:
            // LÓGICA DE CADASTRO (Simplificada para apenas redirecionar com erro se não for 'update')
            // Se cair aqui e não for 'insert' válido (caiu no 'default'), é um erro de ação.
            redirectToError($redirect_new, 'ACAO_INVALIDA');
            break;
    } 
    
} else {
    // Redireciona se for acesso via GET sem submissão de formulário
    header('Location: ' . $redirect_login); 
    exit;
}