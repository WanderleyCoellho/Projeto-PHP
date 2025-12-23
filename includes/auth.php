<?php
session_start(); // Inicia a sessão

// Se não existir a variável de sessão 'usuario_id', chuta para o login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>