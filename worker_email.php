<?php
// worker_email.php
require 'vendor/autoload.php';
require 'includes/config.php'; // Já carrega o .env e o banco
require_once 'classes/EmailService.php';

echo "🤖 Robô de E-mails iniciado... (Pressione Ctrl+C para parar)\n";

$emailService = new EmailService();

while (true) {
    // 1. Busca emails pendentes (pega 5 por vez)
    $stmt = $pdo->prepare("SELECT * FROM fila_emails WHERE status = 'pendente' LIMIT 5");
    $stmt->execute();
    $pendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($pendentes) == 0) {
        // Se não tem nada, descansa por 5 segundos para não gastar CPU
        echo "."; // Mostra que está vivo
        sleep(5);
        continue;
    }

    foreach ($pendentes as $tarefa) {
        echo "\n📧 Enviando para: " . $tarefa['email_destino'] . "... ";

        // Tenta enviar
        if ($emailService->enviarBoasVindas($tarefa['email_destino'], $tarefa['nome_destino'])) {
            // Sucesso: Marca como enviado
            $update = $pdo->prepare("UPDATE fila_emails SET status = 'enviado' WHERE id = ?");
            $update->execute([$tarefa['id']]);
            echo "✅ Sucesso!";
        } else {
            // Erro: Marca erro (poderia ter lógica de tentar de novo)
            $update = $pdo->prepare("UPDATE fila_emails SET status = 'erro', tentativas = tentativas + 1 WHERE id = ?");
            $update->execute([$tarefa['id']]);
            echo "❌ Falha!";
        }
    }
    
    // Descansa 1 segundo entre lotes
    sleep(1);
}
?>