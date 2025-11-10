<?php
// Define o caminho base e carrega dependências
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../utils/SessionController.php'; // Mantido

// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. Definição das URLs de redirecionamento (Certifique-se de que BASE_URL está correto)
$redirect_new = BASE_URL . '/view/user/new.php'; // Cadastro (New Account)
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
    // Se a ação não for passada (formulário de novo usuário não tem campo action), define como 'insert'.
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'insert';
    
    $nome = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    $login = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
    $senha = $_POST['password'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    // Instancia o modelo
    $userModel = new UserModel();

    switch ($action) {
        
        case 'update':
            // ... LÓGICA DE ATUALIZAÇÃO (EDIÇÃO DE PERFIL) (Mantida do original)
            
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

            break; // Fim do 'update'

        case 'insert':
            // =======================================================
            // LÓGICA DE CADASTRO DE NOVO USUÁRIO (INSERT)
            // =======================================================
            $redirect_location = $redirect_new; // Em caso de erro, volta para o cadastro

            // 1. Validação de campos obrigatórios (Nome, Email, Senha, Confirmação)
            if (empty($nome) || empty($login) || empty($senha) || empty($confirmar_senha)) {
                redirectToError($redirect_location, 'CAMPOS_VAZIOS');
            }

            // 2. Validação de senhas
            if ($senha !== $confirmar_senha) {
                redirectToError($redirect_location, 'SENHAS_DIFERENTES');
            }

            // 3. Validação do formato do Email
            if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
                redirectToError($redirect_location, 'EMAIL_INVALIDO');
            }

            // 4. Verificação de unicidade do Email (Login)
            try {
                if ($userModel->buscarPorLogin($login)) {
                    redirectToError($redirect_location, 'EMAIL_EXISTENTE');
                }
            } catch (\Exception $e) {
                 error_log("Erro ao buscar login (Exceção): " . $e->getMessage());
                 redirectToError($redirect_location, 'ERRO_INTERNO_DB');
            }
            
            // 5. Preparação e Inserção
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

            try {
                if ($userModel->inserir($nome, $login, $senha_hashed)) {
                    // SUCESSO! Redireciona para a página de login.
                    header('Location: ' . $redirect_login . '?status=SUCESSO_CADASTRO'); 
                    exit;
                } else {
                    // ERRO: FALHA_AO_INSERIR -> O Model falhou em algum ponto não capturado por exceção.
                    redirectToError($redirect_location, 'FALHA_AO_INSERIR');
                }
            } catch (\Exception $e) {
                error_log("Erro na inserção (Exceção): " . $e->getMessage());
                redirectToError($redirect_location, 'ERRO_INTERNO_DB');
            }

            break; // Fim do 'insert'
            
        default:
            // =======================================================
            // AÇÃO INVÁLIDA (Qualquer coisa que não seja 'update' ou 'insert')
            // =======================================================
            // Agora, apenas a ação desconhecida cai aqui.
            redirectToError($redirect_new, 'ACAO_INVALIDA');
            break;
    } 
    
} else {
    // Redireciona se for acesso via GET sem submissão de formulário
    header('Location: ' . $redirect_login); 
    exit;
}