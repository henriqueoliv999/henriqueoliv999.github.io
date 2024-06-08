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

session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_categoria'])) {
    session_unset();
    session_destroy();
    header("Location: ../pages/login.php");
    exit();
}

$id = $_SESSION['user_id'];
$categoria = $_SESSION['user_categoria'];

// Verifique se o usuário tem permissão para acessar esta página
if ($categoria !== 'Administrador') {
    session_unset();
    session_destroy();
    header("Location: ../pages/permissao.php");
    exit();
}

// Verifique se o ID está presente na URL e corresponde ao ID da sessão
if (!isset($_GET['id']) || $_GET['id'] != $id) {
    session_unset();
    session_destroy();
    header("Location: ../pages/permissao.php");
    exit();
}

// Verifique se o ID do professor está presente na URL
if (!isset($_GET['id'])) {
    header("Location: ../pages/permissao.php");
    exit();
}

$professor_id = $_GET['id_professor'];

// Buscar os dados do professor no banco de dados
$sql = "SELECT id, nome, email, status FROM usuario WHERE id = $professor_id AND categoria = 'Professor'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $professor = $result->fetch_assoc();


    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $status = $_POST['status'];

        // Atualizar os dados do professor
        $sql = "UPDATE usuario SET nome='$nome', email='$email', status='$status' WHERE id=$professor_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: administrador.php?id=$id");
            exit();
        } else {
            echo "Erro ao atualizar os dados: " . $conn->error;
        }
    }
} else {
    echo "Professor não encontrado.";
    header("Location: administrador.php?id=$id");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Professor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/redAI-transparente.png" type="image/png">
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Editar Professor</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $professor['nome']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $professor['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="1" <?php echo $professor['status'] == 'ativo' ? 'selected' : ''; ?>>Ativo</option>
                    <option value="0" <?php echo $professor['status'] == 'inativo' ? 'selected' : ''; ?>>Inativo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="administrador.php?id=<?php echo $id ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>