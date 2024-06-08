<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y/m/d H:i:s');

    // Validação de email e nome
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($nome) && preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/", $nome)) {

        // Verifica se o email já está cadastrado
        $checkEmailQuery = $conn->prepare("SELECT id FROM usuario WHERE email = ?");
        $checkEmailQuery->bind_param("s", $email);
        $checkEmailQuery->execute();
        $checkEmailQuery->store_result();

        if ($checkEmailQuery->num_rows > 0) {
            // Email já cadastrado
            $checkEmailQuery->close();
            $conn->close();
            header("Location: ../pages/index.php?sucesso=0&erro=1");
            exit();
        } else {
            // Email não cadastrado, prosseguir com o registro
            $checkEmailQuery->close();

            // Hash da senha
            $hashedSenha = password_hash($senha, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, criado) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $email, $hashedSenha, $data);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                header("Location: ../pages/index.php?sucesso=1");
                exit();
            } else {
                $stmt->close();
                $conn->close();
                header("Location: ../pages/index.php?sucesso=0&erro=2");
                exit();
            }
        }
    } else {
        $conn->close();
        header("Location: ../pages/index.php?sucesso=0&erro=3");
        exit();
    }
}

$conn->close();
