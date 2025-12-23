<?php
include 'includes/auth.php';
include 'includes/config.php';
require_once 'classes/Cliente.php';

// Se enviou o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia o cliente
    $cliente = new Cliente($pdo);

    // Define os valores nos atributos do objeto
    $cliente->nome = $_POST['nome'];
    $cliente->email = $_POST['email'];
    $cliente->telefone = $_POST['telefone'];

    // Chama o método criar()
    if ($cliente->criar()) {
        header("Location: index.php"); // Sucesso
    } else {
        echo "Erro ao cadastrar."; // Falha (em produção usaríamos um alerta melhor)
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