<?php
include 'includes/auth.php';
include 'includes/config.php';
require_once 'classes/Cliente.php';

// Verifica se tem ID na URL
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Instancia o objeto
$cliente = new Cliente($pdo);
$cliente->id = $id; // Define qual ID vamos mexer

// SE O FORMULÁRIO FOI ENVIADO (Salvar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente->nome = $_POST['nome'];
    $cliente->email = $_POST['email'];
    $cliente->telefone = $_POST['telefone'];

    if ($cliente->atualizar()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao atualizar.";
    }
}

// BUSCA OS DADOS PARA PREENCHER O FORMULÁRIO
$usuario = $cliente->lerPorId();

// Se não achou ninguém com esse ID, volta
if (!$usuario) {
    header("Location: index.php");
    exit;
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Editar Usuário</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Atualizar</button>
                    <a href="index.php" class="btn btn-link w-100 mt-2 text-decoration-none">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>