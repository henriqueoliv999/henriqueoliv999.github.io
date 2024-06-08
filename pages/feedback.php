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
$sql = "SELECT * FROM contato";
$result = $conn->query($sql);
$sql2 = "SELECT nome FROM usuario WHERE id=$id";
$result2 = $conn->query($sql2);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RedAI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/redAI-transparente.png" type="image/png">
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../pages/index.php">
                <img src="../img/horizontal-transparente.png" alt="Logo" height="100" class="d-inline-block align-text-top resp">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link menu" href="../pages/logout.php" role="button">Sair</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu" href="../pages/administrador.php?id=<?php echo $id ?>" role="button">Painel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu active" href="../pages/feedback.php?id=<?php echo $id ?>" role="button">Feedbacks</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <p class="primeiro-paragrafo">Olá, </p>
        <p class="segundo-paragrafo">
            <?php
            if ($result2 && $result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                echo htmlspecialchars($row['nome']);
            } else {
                echo "Nenhum resultado encontrado.";
            }
            ?>
        </p>
    </div>

    <div class="container mt-5">
        <p class="primeiro-paragrafo">Feedbacks</p>
        <div class="table-responsive">
            <table class="table table-borderless table-dark table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Categoria</th>
                        <th>Telefone</th>
                        <th>Mensagem</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars(ucfirst(trim($row['id'])));; ?></td>
                                <td><?php echo htmlspecialchars(ucfirst(trim($row['nome'])));; ?></td>
                                <td><?php echo htmlspecialchars(ucfirst(trim($row['email'])));; ?></td>
                                <td><?php echo htmlspecialchars(ucfirst(trim($row['categoria'])));; ?></td>
                                <td><?php echo htmlspecialchars(ucfirst(trim($row['telefone'])));; ?></td>
                                <td><?php echo htmlspecialchars(ucfirst(trim($row['criado']))); ?></td>
                                <td><?php echo htmlspecialchars(ucfirst(trim($row['mensagem']))); ?></td>
                                <td><a href="responder_feedback.php?id=<?php echo $id ?>&id_feedback=<?php echo $row['id']; ?>" class="btn btn-primary">Responder</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8">Nenhum feedback encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <br><br><br>
    <footer class="bg-dark text-white text-center text-lg-start mt-auto">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Sobre nós</h5>
                    <p>
                        Um plataforma gratuita baseada em um projeto de TCC, com fim de auxiliar professores na correção de redações de alunos.
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links úteis</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="../pages/logout.php" class="text-white">Sair</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Contato</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="mailto:henrique.oliveira83@fatec.sp.gov.br" class="text-white">henrique.oliveira83@fatec.sp.gov.br</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 RedAI:
            <a class="text-white" href="#">www.RedAI.com</a>
        </div>
    </footer>
</body>

</html>

<?php $conn->close(); ?>