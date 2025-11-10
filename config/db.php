<?php
date_default_timezone_set('America/Sao_Paulo');

class Database {
    private $host = "localhost";
    private $dbname = "givanildo";
    private $username = "root";
    private $password = "";
    private $pdo;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
$protocol = 'http://';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
    $protocol = 'https://';
}

// O host é o domínio (ex: localhost, ou projeto-givanildo-82e0a.wasmer.app)
$host = $_SERVER['HTTP_HOST'];

// 2. Verifica o ambiente de execução

// Se o host contém 'wasmer.app', é o ambiente de produção
if (strpos($host, 'wasmer.app') !== false) {
    // No Wasmer, o projeto é a raiz do subdomínio. Ex: https://domain.wasmer.app
    define('BASE_URL', $protocol . $host);

} else {
    // Ambiente local (geralmente localhost).
    // Aqui você adiciona o nome do subdiretório usado no seu ambiente local (XAMPP/WAMP).
    // Certifique-se de que NÃO HÁ uma barra final (trailing slash) aqui.
    define('BASE_URL', $protocol . $host . '/Projeto_Givanildo');
}


?>