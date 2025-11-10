<?php
session_start();

class SessionController {
    public static function login($id, $usuario, $nome) {
        $_SESSION['id_usuario'] = $id;
         $_SESSION['usuario'] = $usuario;
        $_SESSION['nome'] = $nome;
    }

    public static function logout() {
        session_destroy();
    }
    public static function setAlert(string $type, string $message): void {
        // Armazena a mensagem
        $_SESSION['alerts'][] = ['type' => $type, 'message' => $message];
    }

        public static function getAlerts(): array {
        $alerts = $_SESSION['alerts'] ?? []; // Pega os alertas
        unset($_SESSION['alerts']); // Limpa os alertas após a leitura
        return $alerts;
    }

    public static function isLoggedIn() {
        return isset($_SESSION['id_usuario']);
    }

    public static function getUsuario() {   
        return $_SESSION['usuario'] ?? null;
    }
        
    public static function getIdUsuario() {
        return $_SESSION['id_usuario'] ?? null;
    }

        public static function getNomeUsuario() {
        return $_SESSION['nome'] ?? null;
    }
}
?>