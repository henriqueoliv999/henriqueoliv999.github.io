<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "feedback_system";
    $conexao = new mysqli($servername, $username, $password, $dbname);

    // Verifique se o e-mail existe no banco de dados
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Gerar um token único
        $token = bin2hex(random_bytes(50));
        $sql = "UPDATE usuario SET token = ?, token_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Enviar e-mail
        $link = "../pages/redefinir-senha.php?token=" . $token;
        $mensagem = "Clique no link para redefinir sua senha: " . $link;

        $mail = new PHPMailer(true);
        try {
            // Configurações do servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP do Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'henrique.s.oliveira1998@gmail.com'; // Seu endereço de e-mail
            $mail->Password = 'Avcdd754800123'; // Sua senha de e-mail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remetente e destinatário
            $mail->setFrom('henrique.s.oliveira1998@gmail.com', 'RedAI');
            $mail->addAddress($email);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Redefinição de Senha - RedAI';
            $mail->Body    = $mensagem;

            $mail->send();
            echo "Um e-mail foi enviado para você com instruções para redefinir sua senha.";
        } catch (Exception $e) {
            echo "O e-mail não pôde ser enviado. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "E-mail não encontrado.";
    }
}
