<?php
require_once "app/config.php";

if (isset($_POST["elimina"])) {
    $id = $_POST["id"];

    $prepara = mysqli_prepare($link, "DELETE FROM utenza WHERE id = ?");
    mysqli_stmt_bind_param($prepara, "i", $id);

    if (mysqli_stmt_execute($prepara)) {
        echo "Utente eliminato!";
    } else {
        echo "Errore durante l'eliminazione.";
    }

    mysqli_stmt_close($prepara);
}

$risultato = mysqli_query($link, "SELECT id, nome, verifica FROM utenza WHERE nome != 'Luca'");
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Gestione utenti</title>
</head>

<body>

    <h1>Gestione utenti</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Password</th>
            <th>Azioni</th>
        </tr>

        <?php while ($utente = mysqli_fetch_assoc($risultato)) { ?>
            <tr>
                <td><?= $utente["id"] ?></td>
                <td><?= htmlspecialchars($utente["nome"]) ?></td>
                <td>Protetta (hash)</td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id"
                            value="<?= $utente["id"] ?>">
                        <button type="submit" name="elimina"
                            onclick="return confirm('Vuoi eliminare questo utente?')">
                            Elimina
                        </button>
                    </form>
                </td>
            </tr>
        <?php } ?>

    </table>

</body>

</html>