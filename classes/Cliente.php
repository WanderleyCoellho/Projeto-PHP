<?php
class Cliente {
    private $conn;
    private $table_name = "usuarios"; // Mapeia para sua tabela original

    // Atributos do Cliente (Espelho do Banco)
    public $id;
    public $nome;
    public $email;
    public $telefone;

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- MÉTODO LER (Read) ---
    public function ler() {
        // Seleciona todos ordenando pelo mais recente
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // --- MÉTODO CRIAR (Create) ---
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, email=:email, telefone=:telefone";
        $stmt = $this->conn->prepare($query);

        // Limpeza (Segurança)
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));

        // Bind (Vincular valores)
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefone", $this->telefone);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // --- LER UM ÚNICO CLIENTE (Para o Edit) ---
    public function lerPorId() {
        // Usa o ID que já está no objeto ($this->id)
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- ATUALIZAR (Update) ---
    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, email = :email, telefone = :telefone 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Limpeza
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // --- DELETAR (Delete) ---
    public function deletar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>