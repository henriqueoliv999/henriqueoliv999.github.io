<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_system";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $mensagem = trim($_POST['mensagem']);

    // Validação
    if (empty($nome) || !preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/", $nome) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($telefone) || !preg_match("/^[0-9]{11}$/", $telefone) || empty($mensagem)) {
        header("Location: ../pages/contato.php?sucesso=0&erro=1");
    } else {
        var_dump($telefone);
        $stmt = $conn->prepare("INSERT INTO contato (nome, email, telefone, mensagem) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $telefone, $mensagem);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: ../pages/contato.php?sucesso=1");
            exit();
        } else {
            $stmt->close();
            $conn->close();
            header("Location: ../pages/contato.php?sucesso=0&erro=2");
            exit();
        }
    }
}
$conn->close();
