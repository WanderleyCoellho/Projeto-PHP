<?php
// Carrega as dependências
include 'includes/config.php';
require_once 'classes/Usuario.php'; // Carrega a classe Usuario

session_start();

// Se já estiver logado, manda pra home
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // --- AQUI COMEÇA A MUDANÇA (POO) ---
    
    // 1. Instancia o usuário passando a conexão ($pdo vem do config.php)
    $usuario = new Usuario($pdo);

    // 2. Chama o método logar() que criamos lá na classe
    if ($usuario->logar($email, $senha)) {
        header("Location: index.php");
        exit;
    } else {
        $erro = "Email ou senha incorretos!";
    }
    // ------------------------------------
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DevCRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Bem-vindo</h3>
        <p class="text-muted">Faça login para continuar</p>
    </div>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'criado'): ?>
        <div class="alert alert-success p-2 text-center">
            Usuário criado com sucesso! Faça login.
        </div>
    <?php endif; ?>

    <?php if($erro): ?>
        <div class="alert alert-danger p-2 text-center"><?= $erro ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="admin@teste.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" placeholder="******" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">Entrar no Sistema</button>
    </form>
    
    <div class="text-center mt-4 pt-3 border-top">
        <p class="mb-1 text-muted small">Ainda não tem acesso?</p>
        <a href="register.php" class="btn btn-outline-secondary btn-sm w-100">Criar Nova Conta</a>
    </div>
</div>

</body>
</html>