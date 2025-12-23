<?php
include 'includes/auth.php';
include 'includes/config.php';
require 'vendor/autoload.php'; // Carrega o Composer
require_once 'classes/Cliente.php';
require_once 'classes/EmailService.php'; // Carrega nosso serviço de email

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = new Cliente($pdo);
    $cliente->nome = $_POST['nome'];
    $cliente->email = $_POST['email'];
    $cliente->telefone = $_POST['telefone'];

    if ($cliente->criar()) {       
        // --- Em vez de enviar, agendamos na fila ---
        $sqlFila = "INSERT INTO fila_emails (email_destino, nome_destino) VALUES (:email, :nome)";
        $stmtFila = $pdo->prepare($sqlFila);
        $stmtFila->execute([
            ':email' => $cliente->email,
            ':nome' => $cliente->nome
        ]);
        // ----------------------------------------------------

        header("Location: index.php?msg=sucesso");
    } else {
        echo "Erro ao cadastrar.";
    }
    exit;
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Novo Usuário</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Salvar</button>
                    <a href="index.php" class="btn btn-link w-100 mt-2 text-decoration-none">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>