<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Garante que o composer tá carregado

// Carrega as variáveis do arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad(); // safeLoad evita erro se o arquivo não existir

require_once __DIR__ . '/../classes/Database.php';

// Instancia o objeto (Cria uma cópia da classe na memória)
$database = new Database();

// Pega a conexão e guarda na variável $pdo
// Fazemos isto para NÃO QUEBRAR o resto do seu código (index.php, create.php, etc) que já usa $pdo
$pdo = $database->getConnection();
?>