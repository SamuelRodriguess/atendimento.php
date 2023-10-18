<html>

<head>
    <title>PHP CodeSandbox</title>
</head>

<body>
    <h1>Atendimento</h1>

    <?php
    include('Atendimento.php');
    include('AtendimentoDAO.php');
    include('DatabaseConnection.php');

    $databaseConnection = new DatabaseConnection();
    $databaseConnection->connect();

    $connection = $databaseConnection->getConnection();
    $atendimentoDAO = new AtendimentoDAO($connection);

    $atendimento1 = new Atendimento(1, 0, "Normal");
    $atendimento2 = new Atendimento(2, 0, "Prioritário");

    $atendimentoDAO->criarAtendimento($atendimento1);
    $atendimentoDAO->criarAtendimento($atendimento2);

    $encontrado = $atendimentoDAO->buscarAtendimento(1);
    if ($encontrado) {
        echo "Atendimento encontrado: ID " . $encontrado->getId() . " - Tipo " . $encontrado->getTipo() . "<br>";
    }

    $atendimento1 = new Atendimento(1, 123, "Normal");
    $atendimentoDAO->atualizarAtendimento($atendimento1);

    $atendimentos = $atendimentoDAO->buscarTodosAtendimentos();
    foreach ($atendimentos as $atendimento) {
        echo "ID: " . $atendimento->getId() . "<br>";
        echo "Tipo: " . $atendimento->getTipo() . "<br><br>";
    }

    $atendimentoDAO->excluirAtendimento(1);
    $atendimentoDAO->excluirAtendimento(2);

    $novaSenhaNormal = $atendimentoDAO->gerarSenhaNormal();
    echo "Nova senha Normal gerada: ID " . $novaSenhaNormal->getId() . " - Tipo " . $novaSenhaNormal->getTipo() . "<br>";

    $novaSenhaPrioritaria = $atendimentoDAO->gerarSenhaPrioritario();
    echo "Nova senha Prioritária gerada: " . $novaSenhaPrioritaria->getId() . " - Senha: " . $novaSenhaPrioritaria->getSenha() . " - Tipo " . $novaSenhaPrioritaria->getTipo() . "<br>";

    $senhas = $atendimentoDAO->retornaSenhas();
    foreach ($senhas as $senha) {
        echo "ID: " . $senha->getId() . " - Senha: " . $senha->getSenha() . " - Tipo " . $senha->getTipo() . "<br>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gerarSenhaNormal'])) {
        $novaSenhaNormal = $atendimentoDAO->gerarSenhaNormal();
        echo "Nova senha Normal gerada: ID " . $novaSenhaNormal->getId() . " - Senha " . $novaSenhaNormal->getSenha() . " - Tipo " . $novaSenhaNormal->getTipo() . "<br>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gerarSenhaPrioritario'])) {
        $novaSenhaPrioritaria = $atendimentoDAO->gerarSenhaPrioritario();
        echo "Nova senha Prioritária gerada: ID " . $novaSenhaPrioritaria->getId() . " - Senha: " . $novaSenhaPrioritaria->getSenha() . " - Tipo " . $novaSenhaPrioritaria->getTipo() . "<br>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atenderSenha'])) {
        $senhaAtendida = $atendimentoDAO->atendimentoSenha();
        if ($senhaAtendida) {
            echo "Senha a ser atendida: ID " . $senhaAtendida->getId() . " - Senha: " . $senhaAtendida->getSenha() . " - Tipo " . $senhaAtendida->getTipo() . "<br>";
        } else {
            echo "Não há senhas para atender.<br>";
        }
    }

    $databaseConnection->disconnect();
    ?>

    <form method="POST">
        <input type="submit" name="gerarSenhaNormal" value="Gerar Senha Normal">
    </form>

    <form method="POST">
        <input type="submit" name="gerarSenhaPrioritario" value="Gerar Senha Prioritária">
    </form>

    <form method="POST">
        <input type="submit" name="atenderSenha" value="Atender Senha">
    </form>
</body>
</html>
