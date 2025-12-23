<?php
class Database {
    // Atributos privados (Encapsulamento)
    private $host = 'localhost';
    private $db_name = 'crud_simples';
    private $username = 'root';
    private $password = 'Wanderley32685669@@'; // Se tiver senha, coloque aqui
    public $conn;

    // Método (Função) para ligar ao banco
    public function getConnection() {
        $this->conn = null;

        try {
            // O 'this->' serve para aceder às variáveis desta própria classe
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            // Configurações de erro
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Corrige caracteres acentuados (UTF-8)
            $this->conn->exec("set names utf8");
            
        } catch(PDOException $exception) {
            echo "Erro de ligação: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>