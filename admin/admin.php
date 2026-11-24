<?php
require_once __DIR__ . "/../app/config.php";

// Aggiorna il consenso dell'utente selezionato.
if (isset($_POST["id"], $_POST["azione"])) {
    $id = (int) $_POST["id"];
    $azione = $_POST["azione"];

    if ($id <= 0 || !in_array($azione, ["consenti", "revoca"], true)) {
        http_response_code(400);
        exit("Richiesta non valida.");
    }

    $verifica = $azione === "consenti" ? 1 : 0;
    $prepara = mysqli_prepare($link, "UPDATE utenza SET verifica = ? WHERE ID = ?");
    if ($prepara === false) {
        die("Errore nella preparazione SQL: " . mysqli_error($link));
    }

    if (!mysqli_stmt_bind_param($prepara, "ii", $verifica, $id)) {
        die("Errore nell'associazione dei parametri: " . mysqli_stmt_error($prepara));
    }

    if (!mysqli_stmt_execute($prepara)) {
        die("Errore durante l'aggiornamento: " . mysqli_stmt_error($prepara));
    }

    mysqli_stmt_close($prepara);
    header("Location: admin.php");
    exit;
}

// Carica gli utenti e il loro stato di accesso, escludendo l'utente "Luca".

$risultato = mysqli_query($link, "SELECT id, nome, verifica FROM utenza WHERE nome != 'Luca' AND nome != 'admin'");
if ($risultato === false) {
    die("Errore nel caricamento degli utenti: " . mysqli_error($link));
}

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
            <th>Stato accesso</th>
            <th>Azioni</th>
        </tr>

        <!-- Mostra lo stato e l'azione disponibile per ogni utente. -->
        <?php while ($utente = mysqli_fetch_assoc($risultato)) { ?>
            <?php $azione = (int) $utente["verifica"] === 1 ? "revoca" : "consenti"; ?>
            <tr>
                <td><?= $utente["id"] ?></td>
                <td><?= htmlspecialchars($utente["nome"]) ?></td>
                <td><?= $azione === "revoca" ? "Consenso attivo" : "In attesa" ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id"
                            value="<?= $utente["id"] ?>">
                        <button type="submit" name="azione" value="<?= $azione ?>"
                            onclick="return confirm('<?= $azione === "consenti" ? "Vuoi consentire l'accesso?" : "Vuoi rimuovere il consenso?" ?>')">
                            <?= $azione === "consenti" ? "Consenti" : "Rimuovi consenso" ?>
                        </button>
                    </form>
                </td>
            </tr>
        <?php } ?>

    </table>

</body>

</html>