<?php
//incluindo a conexão com o banco de dados
include 'db.php';
//Verificando se o formulário foi enviado
if($_SERVER["REQUEST_METHOD"] == 'POST') {
    //Obtendo os dados do formulário
    $nome = $_POST['nome'];
    $nome_curso = $_POST['nome_curso'];

    // Buscando o id do aluno pelo nome
    $sql_aluno = "SELECT id_aluno FROM alunos WHERE nome = ?";
    if ($stmt_aluno = $mysqli->prepare($sql_aluno)) {
        $stmt_aluno->bind_param("s", $nome);
        $stmt_aluno->execute();
        $stmt_aluno->store_result();
        $stmt_aluno->bind_result($id_aluno);

        if ($stmt_aluno->num_rows > 0) {
            $stmt_aluno->fetch();
        } else {
            echo "Aluno não encontrado.";
            exit();
        }
        $stmt_aluno->close();
    } else {
        echo "Erro ao buscar aluno: " . $mysqli->error;
        exit();
    }

    // Buscando o id do curso pelo nome
    $sql_curso = "SELECT id_curso FROM cursos WHERE nome_curso = ?";
    if ($stmt_curso = $mysqli->prepare($sql_curso)) {
        $stmt_curso->bind_param("s", $nome_curso);
        $stmt_curso->execute();
        $stmt_curso->store_result();
        $stmt_curso->bind_result($id_curso);

        if ($stmt_curso->num_rows > 0) {
            $stmt_curso->fetch();
        } else {
            echo "Curso não encontrado.";
            exit();
        }
        $stmt_curso->close();
    } else {
        echo "Erro ao buscar curso: " . $mysqli->error;
        exit();
    }

    // Preparando a consulta SQL para inserir os dados
    $sql = "INSERT INTO matricula (id_aluno, id_curso) VALUES (?, ?)";
    
    // Preparando a declaração (prepared statement)
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind os parâmetros da consulta
        $stmt->bind_param("ii", $id_aluno, $id_curso);

        //Executando a consultas
        if ($stmt->execute()) {
            echo "Matricula cadastrada com sucesso!";
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
    <title>Cadastro de Matrículas</title>
</head>
<header>
    <img src="img/LOGO_ESCOLA.svg" alt="Logo da Escola">
    <h1>Cadastro de Matrículas</h1>
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
    <form name="form" action="cadastrar_matricula.php" method="POST">
        <label for="nome">Aluno:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="nome_curso">Curso:</label><br>
        <input type="text" id="nome_curso" name="nome_curso" required><br><br>

        <button id="button" type="submit">Cadastrar</button>
    </form>

</body>
</html>