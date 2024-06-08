<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_BCRYPT);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "feedback_system";
    // Verifique se o token é válido e não expirou
    $conexao = new mysqli($servername, $username, $password, $dbname);
    $sql = "SELECT * FROM usuario WHERE token = ? AND token_expira > NOW()";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Atualize a senha e remova o token
        $sql = "UPDATE usuario SET senha = ?, token = NULL, token_expira = NULL WHERE token = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $nova_senha, $token);
        $stmt->execute();

        echo "Sua senha foi redefinida com sucesso.";
    } else {
        echo "Token inválido ou expirado.";
    }
}
?>
