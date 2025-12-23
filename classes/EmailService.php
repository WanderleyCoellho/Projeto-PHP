<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $mail;

    public function __construct() {
        // Carrega o .env da raiz
        // dirname(__DIR__) pega a pasta pai de 'classes', ou seja, a raiz
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->safeLoad();

        $this->mail = new PHPMailer(true);

        try {
            // Configurações do Servidor
            // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; // Descomente se der erro
            $this->mail->isSMTP();
            $this->mail->Host       = $_ENV['EMAIL_HOST'];
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = $_ENV['EMAIL_USER'];
            $this->mail->Password   = $_ENV['EMAIL_PASS'];
            $this->mail->Port       = $_ENV['EMAIL_PORT'];
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            // Quem envia
            $this->mail->setFrom($_ENV['EMAIL_USER'], 'Sistema DevCRUD');
            $this->mail->CharSet = 'UTF-8';

        } catch (Exception $e) {
            // Em produção, você registraria isso num arquivo de log
            // error_log("Erro Email: " . $this->mail->ErrorInfo);
        }
    }

    public function enviarBoasVindas($emailDestino, $nomeDestino) {
        try {
            $this->mail->addAddress($emailDestino, $nomeDestino);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'Bem-vindo ao Sistema! 🚀';
            
            $corpo = "
            <div style='font-family: Arial; color: #333;'>
                <h1>Olá, $nomeDestino!</h1>
                <p>Seu cadastro foi realizado com sucesso.</p>
                <p>Agora você faz parte do time.</p>
                <br>
                <small>Atenciosamente,<br>Equipe DevCRUD</small>
            </div>
            ";
            
            $this->mail->Body = $corpo;
            $this->mail->AltBody = "Olá $nomeDestino, seu cadastro foi realizado com sucesso.";

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>