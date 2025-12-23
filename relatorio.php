<?php
// 1. Carrega o autoloader do Composer (Mágica!)
require 'vendor/autoload.php';

// 2. Carrega nossas configurações
include 'includes/config.php';
require_once 'classes/Cliente.php';

// Referencia o namespace do Dompdf
use Dompdf\Dompdf;

// 3. Busca os dados do banco (Reaproveitando sua Classe!)
$cliente = new Cliente($pdo);
$stmt = $cliente->ler();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4. Monta o HTML que vai virar PDF
$html = '
<h1>Relatório de Usuários</h1>
<table border="1" width="100%" style="border-collapse: collapse;">
    <thead>
        <tr style="background-color: #ccc;">
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>';

foreach ($usuarios as $user) {
    $html .= '<tr>';
    $html .= '<td style="padding: 5px;">' . $user['nome'] . '</td>';
    $html .= '<td style="padding: 5px;">' . $user['email'] . '</td>';
    $html .= '<td style="padding: 5px;">' . $user['telefone'] . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';
$html .= '<p>Gerado em: ' . date('d/m/Y H:i') . '</p>';

// 5. Inicializa o Dompdf e gera o arquivo
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Papel A4, Retrato
$dompdf->render();

// 6. Envia o PDF para o navegador (Download)
$dompdf->stream("relatorio_clientes.pdf", ["Attachment" => false]); 
// Se quiser que baixe direto, mude para true
?>