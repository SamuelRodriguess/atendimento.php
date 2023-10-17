<?php
    include('Atendimento.php');
    include('HandleAtendimento.php');

    include('DatabaseConnection.php');
    $databaseConnection = new DatabaseConnection();
    $databaseConnection->connect();
?>
<html>

<head>
    <title>PHP Starter</title>
</head>

<body>
    <h1>PHP Starter in CodeSandbox</h1>
    <?php phpinfo(); ?>
</body>

</html>