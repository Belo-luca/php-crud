
<?php
require_once "../tabella/config.php";

if (isset($_POST["consenso"])) {
    $id = $_POST["id"];

    $prepara = mysqli_prepare($link, "UPDATE utenza SET verifica = TRUE WHERE ID = ?");
    mysqli_stmt_bind_param($prepara, "i", $id);

    if (mysqli_stmt_execute($prepara)) {
        echo "Utente Può accedere";
    } else {
        echo "Errore nel codice";
    }
    mysqli_stmt_close($prepara);
}

$risultato = mysqli_query($link, "SELECT id, nome FROM utenza");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Consenti accesso</title>
</head>
<body>

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
                <td>Segreta</td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id"
                               value="<?= $utente["id"] ?>">
                        <button type="submit" name="consenso"
                                onclick="return confirm('Vuoi consentire di accedere?')">
                            Consenti
                        </button>
                    </form>
                </td>
            </tr>
        <?php } ?>

    </table>

</body>
</html>
