<?php
include 'includes/auth.php';
include 'includes/config.php';
require_once 'classes/Cliente.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $cliente = new Cliente($pdo);
    $cliente->id = $id; // Diz ao objeto qual ID apagar
    
    if($cliente->deletar()) {
        // Sucesso
    } else {
        // Opcional: Tratar erro
    }
}

header("Location: index.php");
exit;
?>