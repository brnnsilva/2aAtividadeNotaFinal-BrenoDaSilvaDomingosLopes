<?php include 'database.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tarefas</title>
</head>
<body>
    <h1>Gerenciador de Tarefas</h1>

    <h2>Adicionar Tarefa</h2>
    <form action="add_tarefa.php" method="POST">
        <input type="text" name="descricao" placeholder="Descrição" required>
        <input type="date" name="vencimento" required>
        <button type="submit">Adicionar</button>
    </form>

    <h2>Tarefas Não Concluídas</h2>
    <ul>
        <?php
            $lista = $db->query("SELECT * FROM tarefas WHERE concluida = 0");
            foreach ($lista as $tarefa):
        ?>
        <li>
            <?= $tarefa['descricao'] ?> - Vence em: <?= $tarefa['vencimento'] ?>
            <a href="update_tarefa.php?id=<?= $tarefa['id'] ?>">Concluir</a>
            <a href="delete_tarefa.php?id=<?= $tarefa['id'] ?>">Excluir</a>
        </li>
        <?php endforeach; ?>
    </ul>

    <h2>Tarefas Concluídas</h2>
    <ul>
        <?php
            $lista = $db->query("SELECT * FROM tarefas WHERE concluida = 1");
            foreach ($lista as $tarefa):
        ?>
        <li>
            ✔ <?= $tarefa['descricao'] ?> (Concluída)
            <a href="delete_tarefa.php?id=<?= $tarefa['id'] ?>">Excluir</a>
        </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>
<?php
$db = new PDO('sqlite:tarefas.db');

$db->exec("CREATE TABLE IF NOT EXISTS tarefas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    descricao TEXT,
    vencimento TEXT,
    concluida INTEGER
)");
?>
<?php
include 'database.php';

$descricao = $_POST['descricao'];
$vencimento = $_POST['vencimento'];

$stmt = $db->prepare("INSERT INTO tarefas (descricao, vencimento, concluida) VALUES (?, ?, 0)");
$stmt->execute([$descricao, $vencimento]);

header("Location: index.php");
exit;
?>
<?php
include 'database.php';

$id = $_GET['id'];

$db->exec("UPDATE tarefas SET concluida = 1 WHERE id = $id");

header("Location: index.php");
exit;
?>
<?php
include 'database.php';

$id = $_GET['id'];

$db->exec("DELETE FROM tarefas WHERE id = $id");

header("Location: index.php");
exit;
?>
