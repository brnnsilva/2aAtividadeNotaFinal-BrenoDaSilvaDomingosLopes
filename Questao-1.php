<?php require 'database.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Livraria</title>
</head>
<body>

<h1>Livros cadastrados</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th><th>Título</th><th>Autor</th><th>Ano</th>
    </tr>

    <?php
    foreach ($db->query("SELECT * FROM livros") as $livro) {
        echo "<tr>
                <td>{$livro['id']}</td>
                <td>{$livro['titulo']}</td>
                <td>{$livro['autor']}</td>
                <td>{$livro['ano']}</td>
              </tr>";
    }
    ?>
</table>

<h2>Adicionar Livro</h2>
<form method="POST" action="add_book.php">
    <input type="text" name="titulo" placeholder="Título" required>
    <input type="text" name="autor" placeholder="Autor" required>
    <input type="number" name="ano" placeholder="Ano" required>
    <button>Adicionar</button>
</form>

<h2>Excluir Livro</h2>
<form method="POST" action="delete_book.php">
    <input type="number" name="id" placeholder="ID" required>
    <button>Excluir</button>
</form>

</body>
</html>
<?php
$db = new PDO("sqlite:livros.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS livros (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT,
    autor TEXT,
    ano INTEGER
)");
?>
<?php
require 'database.php';

$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$ano = $_POST['ano'];

$db->exec("INSERT INTO livros (titulo, autor, ano) VALUES ('$titulo', '$autor', '$ano')");

header("Location: index.php");
<?php
require 'database.php';

$id = $_POST['id'];

$db->exec("DELETE FROM livros WHERE id = $id");

header("Location: index.php");
