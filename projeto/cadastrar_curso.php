<?php
//incluindo a conexão com o banco de dados
include 'db.php';
//Verificando se o formulário foi enviado
if($_SERVER["REQUEST_METHOD"] == 'POST') {
    //Obtendo os dados do formulário
    $nome_curso = $_POST['nome_curso'];
    $descricao = $_POST['descricao'];
    $carga_horaria = $_POST['carga_horaria'];

    //Preparando a consulta SQL para inserir os dados
    $sql = "INSERT INTO cursos (nome_curso, descricao, carga_horaria)
            VALUES (?, ?, ?)";
            
    //Preparando a declaração (prepared statement)
    if ($stmt = $mysqli->prepare($sql)) {
        //Bind os parâmetros da consulta
        $stmt->bind_param("sss", $nome_curso, $descricao, $carga_horaria);

        //Executando a consulta
        if ($stmt->execute()) {
            echo "Curso cadastrado com sucesso!";
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
    <title>Cadastro de Cursos</title>
</head>
<header>
    <img src="img/LOGO_ESCOLA.svg" alt="Logo da Escola">
    <h1>Cadastro de Cursos</h1>
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
    <form name="form" action="cadastrar_curso.php" method="POST">
        <label for="nome_curso">Nome:</label><br>
        <input type="text" id="nome_curso" name="nome_curso" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <input type="text" id="descricao" name="descricao" required><br><br>

        <label for="carga_horaria">Carga horária:</label><br>
        <input type="text" id="carga_horaria" name="carga_horaria" required><br><br>

        <button id="button" type="submit">Cadastrar</button>
    </form>

</body>
</html>