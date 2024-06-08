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
                        <a class="nav-link menu" aria-current="page" href="../pages/index.php">Cadastre-se e entre na fila!</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle menu" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sobre
                        </a>
                        <ul class="dropdown-menu menu">
                            <li><a class="dropdown-item" href="../pages/quem-somos.php">Quem somos?</a></li>
                            <li><a class="dropdown-item" href="../pages/qual-a-proposta.php">Qual a proposta?</a></li>
                            <li><a class="dropdown-item" href="../pages/o-que-e.php">O que é?</a>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active menu" href="../pages/login.php" role="button">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu" href="../pages/contato.php" role="button">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-4 text-center">
            <div class="image-container">
                <img src="../img/redAI-transparente.png" class="resp-img" height="400px" alt="Logo">
            </div>
            <p>Já possui cadastro? Realize seu login.</p>
            <!-- <form method="POST" action="processar-login.php"> -->
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label"></label>
                    <input type="email" class="form-control" id="formGroupExampleInput" name="email" placeholder="E-mail">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label"></label>
                    <input type="password" class="form-control" id="formGroupExampleInput2" name="senha" placeholder="Senha">
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
            <p><a href="esqueceu-senha.php">Esqueceu sua senha?</a></p><br>
        </div>
    </div>

    <?php
    $mensagem = "";
    if (isset($_GET['erro'])) {
        $erro = $_GET['erro'];
        if ($erro == 1) {
            $mensagem = "Login falhou: credenciais inválidas ou conta inativa.";
        } elseif ($erro == 2) {
            $mensagem = "A verificação falhou. Nenhum campo pode ser nulo, tente novamente.";
        }
    }
    ?>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message"><?php echo $mensagem; ?></p>
        </div>
    </div>
    <script src="../Script/script.js"></script>
    <?php if ($mensagem !== "") : ?>
        <script>
            // Abre o modal se houver uma mensagem
            document.addEventListener('DOMContentLoaded', (event) => {
                var modal = document.getElementById('modal');
                modal.style.display = 'block';
            });
        </script>
    <?php endif; ?>
    <br>
    <footer class="bg-dark text-white text-center text-lg-start mt-auto">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Sobre nós</h5>
                    <p>
                        Um plataforma gratuíta baseada em um projeto de TCC, com fim de auxiliar professores na correção de redações de alunos.
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links úteis</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="../pages/index.php" class="text-white">Home</a>
                        </li>
                        <li>
                            <a href="../pages/login.php" class="text-white">Entrar</a>
                        </li>
                        <li>
                            <a href="../pages/contato.php" class="text-white">Contato</a>
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
            <a class="text-white" href="index.php">www.RedAI.com</a>
        </div>
    </footer>
</body>

</html>