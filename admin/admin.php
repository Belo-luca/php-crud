<?php
session_start();
require_once __DIR__ . "/../app/config.php";

if (empty($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header("Location: ../index.php?errore=sessione");
    exit;
}

if (empty($_SESSION["csrf"])) {
    $_SESSION["csrf"] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["azione"])) {

    if (!isset($_POST["csrf"]) || !hash_equals($_SESSION["csrf"], $_POST["csrf"])) {
        http_response_code(403);
        die("Richiesta non valida.");
    }

    $id = filter_var($_POST["id"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
    $azione = $_POST["azione"];

    if ($id === false || !in_array($azione, ["consenti", "revoca"], true)) {
        http_response_code(400);
        die("Operazione non valida.");
    }

    $verifica = ($azione === "consenti") ? 1 : 0;

    $stmt = mysqli_prepare($link, "UPDATE utenza SET verifica = ? WHERE id = ? AND nome != 'Admin'");
    if (!$stmt) {
        error_log("Errore SQL admin update: " . mysqli_error($link));
        http_response_code(500);
        die("Errore del server.");
    }

    mysqli_stmt_bind_param($stmt, "ii", $verifica, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: admin.php");
    exit;
}

$stmt = mysqli_prepare($link, "SELECT id, nome, verifica FROM utenza WHERE nome NOT IN ('Luca', 'Admin') ORDER BY nome");
if (!$stmt) {
    error_log("Errore SQL admin list: " . mysqli_error($link));
    die("Errore del server.");
}
mysqli_stmt_execute($stmt);
$risultato = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard amministratore</title>
</head>
<body>
    <h1>Dashboard amministratore</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Stato</th>
            <th>Azioni</th>
        </tr>

        <?php while ($utente = mysqli_fetch_assoc($risultato)): ?>
            <?php
            $autorizzato = ((int) $utente["verifica"] === 1);
            $azione = $autorizzato ? "revoca" : "consenti";
            ?>
            <tr>
                <td><?= (int) $utente["id"] ?></td>
                <td><?= htmlspecialchars($utente["nome"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= $autorizzato ? "Autorizzato" : "In attesa" ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION["csrf"], ENT_QUOTES, "UTF-8") ?>">
                        <input type="hidden" name="id" value="<?= (int) $utente["id"] ?>">
                        <button type="submit" name="azione" value="<?= $azione ?>">
                            <?= $autorizzato ? "Revoca accesso" : "Consenti accesso" ?>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="../index.php">Torna alla pagina iniziale</a>
</body>
</html>