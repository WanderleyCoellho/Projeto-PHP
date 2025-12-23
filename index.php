<?php
include 'includes/auth.php';
include 'includes/config.php';
require_once 'classes/Cliente.php'; // Carrega a nova classe

// 1. Instancia o objeto Cliente
$cliente = new Cliente($pdo);

// 2. Chama o método de leitura
$stmt = $cliente->ler();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Gerenciar Usuários</h3>
    <a href="create.php" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Novo Usuário
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th class="text-end pe-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $user): ?>
                <tr>
                    <td class="ps-4"><?= htmlspecialchars($user['nome']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['telefone']) ?></td>
                    <td class="text-end pe-4">
                        <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="delete.php?id=<?= $user['id'] ?>" 
                           onclick="confirmarExclusao(event, this.href)" 
                           class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>