<?php
// Carrega a classe que acabámos de criar
require_once __DIR__ . '/../classes/Database.php';

// Instancia o objeto (Cria uma cópia da classe na memória)
$database = new Database();

// Pega a conexão e guarda na variável $pdo
// Fazemos isto para NÃO QUEBRAR o resto do seu código (index.php, create.php, etc) que já usa $pdo
$pdo = $database->getConnection();
?>