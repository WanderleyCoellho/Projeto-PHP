<?php
class Usuario {
    private $conn; // Variável para guardar a conexão
    private $table_name = "admins"; // Nome da tabela

    // Construtor: Recebe a conexão do banco assim que a classe é chamada
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método de Login: Retorna TRUE se der certo, FALSE se der errado
    public function logar($email, $senha) {
        // 1. Prepara a query (igual fazíamos antes, mas agora encapsulado)
        $query = "SELECT id, nome, senha FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        
        // 2. Limpa os dados (segurança extra)
        $email = htmlspecialchars(strip_tags($email));
        
        // 3. Executa
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // 4. Verifica se achou alguém
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // 5. Verifica a senha criptografada
            if (password_verify($senha, $row['senha'])) {
                // Inicia a sessão aqui mesmo
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['usuario_id'] = $row['id'];
                $_SESSION['usuario_nome'] = $row['nome'];
                
                return true; // Login Sucesso
            }
        }
        
        return false; // Login Falhou
    }
}
?>