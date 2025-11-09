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