<?php
include 'includes/config.php';
session_start();

// Se já estiver logado, não faz sentido cadastrar, manda pra home
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // 1. Validação básica
    if ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem!";
    } else {
        // 2. Verifica se o email já existe
        $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = :email");
        $stmt->execute(['email' => $email]);
        
        if ($stmt->rowCount() > 0) {
            $erro = "Este email já está cadastrado!";
        } else {
            // 3. Criptografa a senha e Salva
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            
            try {
                $sql = "INSERT INTO admins (nome, email, senha) VALUES (:nome, :email, :senha)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'nome' => $nome, 
                    'email' => $email, 
                    'senha' => $senhaHash
                ]);
                
                // Redireciona para o login com mensagem de sucesso (opcional passar via GET ou Sessão)
                header("Location: login.php?msg=criado");
                exit;
            } catch (PDOException $e) {
                $erro = "Erro ao cadastrar: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - DevCRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Criar Conta</h3>
        <p class="text-muted">Preencha os dados para acessar o sistema</p>
    </div>

    <?php if($erro): ?>
        <div class="alert alert-danger p-2 text-center">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $erro ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nome Completo</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" required minlength="6">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Confirmar Senha</label>
                <input type="password" name="confirmar_senha" class="form-control" required minlength="6">
            </div>
        </div>

        <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
            <i class="bi bi-person-plus-fill me-2"></i>Cadastrar
        </button>
    </form>
    
    <div class="text-center mt-4">
        <p class="mb-0">Já tem uma conta?</p>
        <a href="login.php" class="text-decoration-none fw-bold">Faça Login aqui</a>
    </div>
</div>

</body>
</html>