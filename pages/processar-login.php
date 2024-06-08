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
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y/m/d H:i:s');

    // Validação básica de entrada
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($senha)) {
        $stmt = $conn->prepare("SELECT id, nome, email, senha, status, categoria FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id, $nome, $email_bd, $senha_bd, $status, $categoria);
        $stmt->fetch();
        $stmt->close();
        // Verificação da senha e status do usuário
        if (password_verify($senha, $senha_bd) && $status == 1) {
            $update_stmt = $conn->prepare("UPDATE usuario SET ultimo_login = ? WHERE id = ?");
            $update_stmt->bind_param("si", $data, $id);
            $update_stmt->execute();
            $update_stmt->close();
            $conn->close();
            // Iniciar sessão e redirecionar o usuário baseado na categoria
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['user_nome'] = $nome;
            $_SESSION['user_categoria'] = $categoria;

            if ($categoria == 'Professor') {
                header("Location: ../pages/professor.php?id=$id");
            }
            if ($categoria == 'Administrador') {
                header("Location: ../pages/administrador.php?id=$id");
            }
            exit();
        } else {
            // Login falhou: credenciais inválidas ou conta inativa
            header("Location: ../pages/login.php?erro=1");
            exit();
        }
    } else {
        // Dados inválidos
        header("Location: ../pages/login.php?erro=2");
        exit();
    }
}

$conn->close();
