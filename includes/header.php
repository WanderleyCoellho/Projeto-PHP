<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .table-hover tbody tr:hover { background-color: #f1f1f1; }
        .card { border: none; border-radius: 15px; }
        .btn { border-radius: 8px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
  <div class="container">
    <a class="navbar-brand" href="index.php">
        <i class="bi bi-code-slash me-2"></i>DevCRUD
    </a>
    
    <div class="d-flex">
        <span class="navbar-text text-white me-3">
            Olá, <?= $_SESSION['usuario_nome'] ?? 'Visitante' ?>
        </span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
    </div>
  </div>
</nav>

<div class="container">


</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmarExclusao(event, url) {
        event.preventDefault(); // Impede o link de abrir na hora
        
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você não poderá reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }
</script>

</body>
</html>