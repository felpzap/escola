<?php
// Incluindo a conexão com o banco de dados
include 'db.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/LOGO_ESCOLA.ico" type="image/x-icon">
    <title>Visualizar Matrículas</title>
</head>
<header>
    <img src="img/LOGO_ESCOLA.svg" alt="Logo da Escola">
    <h1>Matrículas cadastradas</h1>
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
    <?php
    // Consultar os dados de matrícula, aluno e curso usando INNER JOIN
$sql = "SELECT m.id_matricula, a.nome AS aluno, c.nome_curso AS curso, m.data_matricula
        FROM matricula m
        INNER JOIN alunos a ON m.id_aluno = a.id_aluno
        INNER JOIN cursos c ON m.id_curso = c.id_curso";
        
// Preparar e executar a consulta
if ($result = $mysqli->query($sql)) {
    // Verificar se existem resultados
    if ($result->num_rows > 0) {
        // Exibir os resultados em uma tabela
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr><th>Nome do Aluno</th><th>Nome do Curso</th><th>Data da Matrícula</th></tr>';
        echo '</thead>';
        echo '<tbody>';

        // Percorrer os resultados e exibir cada linha
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['aluno'] . '</td>';              // Nome do Aluno
            echo '<td>' . $row['curso'] . '</td>';              // Nome do Curso
            echo '<td>' . date('d/m/Y H:i', strtotime($row['data_matricula'])) . '</td>';  // Data da Matrícula
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'Nenhuma matrícula encontrada.';
    }
} else {
    echo 'Erro ao consultar as matrículas: ' . $mysqli->error;
}

// Fechar a conexão com o banco de dados
$mysqli->close();
?>
</body>
</html>