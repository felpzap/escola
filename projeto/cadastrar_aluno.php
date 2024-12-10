<?php
//incluindo a conexão com o banco de dados
include 'db.php';
//Verificando se o formulário foi enviado
if($_SERVER["REQUEST_METHOD"] == 'POST') {
    //Obtendo os dados do formulário
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    //Preparando a consulta SQL para inserir os dados
    $sql = "INSERT INTO alunos (nome, data_nascimento, email, telefone)
            VALUES (?, ?, ?, ?)";
            
    //Preparando a declaração (prepared statement)
    if ($stmt = $mysqli->prepare($sql)) {
        //Bind os parâmetros da consulta
        $stmt->bind_param("ssss", $nome, $data_nascimento, $email, $telefone);

        //Executando a consulta
        if ($stmt->execute()) {
            echo "Aluno cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        //Fechando a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $mysqli->error;
    }
}

//Fechando a conexão com o banco de dados
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/LOGO_ESCOLA.ico" type="image/x-icon">
    <title>Cadastro de Alunos</title>
</head>
<header>
    <img src="img/LOGO_ESCOLA.svg" alt="Logo da Escola">
    <h1>Cadastro de Alunos</h1>
    <nav>
        <ul>
            <li><a href="cadastrar_aluno.php">Cadastrar Aluno</a></li>
            <li><a href="cadastrar_curso.php">Cadastrar Curso</a></li>
            <li><a href="cadastrar_matricula.php">Cadastrar Matrícula</a></li>
            <li><a href="visualizar_matriculas.php">Visualizar Matrículas</a></li>
        </ul>
    </nav>    
</header>

<body>
    <form name="form" action="cadastrar_aluno.php" method="POST">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="data_nascimento">Data de nascimento:</label><br>
        <input type="date" id="data_nascimento" name="data_nascimento" required><br><br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="telefone">Telefone:</label><br>
        <input type="text" id="telefone" name="telefone" required><br><br>

        <button id="button" type="submit">Cadastrar</button>
    </form>

</body>
</html>