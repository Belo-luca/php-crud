<?php
require_once "app/config.php";
$nome = trim($_POST["nome"]);
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);
$comando = "INSERT INTO utenza (nome, password, verifica) VALUES (?, ?, ?)";
$query = mysqli_prepare($link, $comando);
$stato = 0;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    mysqli_stmt_bind_param($query, "ssi", $nome, $hash, $stato);
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    header("Location: index.php");
    exit;
} catch (mysqli_sql_exception $e) {

    if ($e->getCode() == 1062) {
        header("Location: index.php?errore=utente");
    } else {
        header("Location: index.php?errore=registrazione");
    }
}
