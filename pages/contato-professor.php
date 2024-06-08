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
$nome = $_SESSION['user_nome'];
//$email = $_SESSION['email'];

var_dump($id);
var_dump($categoria);
var_dump($nome);
//var_dump($email);

// Verifique se o usuário tem permissão para acessar esta página
if ($categoria !== 'Professor') {
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

$professor_id = $_GET['id'];

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mensagem = $_POST['mensagem'];

    // Atualizar os dados do professor
    $sql = "INSERT INTO contato nome='$nome', email='$email', categoria='$categoria', mensagem=$mensagem";
    if ($conn->query($sql) === TRUE) {
        header("Location: professor.php?id=$id");
        exit();
    } else {
        echo "Erro ao Enviar os dados: " . $conn->error;
    }
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
        <h2>Enviar contato</h2><br>
        <form action="" method="post">
            <div class="mb-3">
                <input placeholder="Mensagem" type="textbox" class="form-control" id="mensagem" name="mensagem" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="professor.php?id=<?php echo $id ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>