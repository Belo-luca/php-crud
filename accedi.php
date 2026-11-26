<?php
session_start();
require_once "app/config.php";

function vaiA(string $errore = ""): void
{
    $url = "index.php" . ($errore !== "" ? "?errore=" . urlencode($errore) : "");
    header("Location: " . $url);
    exit;
}

// Accetta solo POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    vaiA();
}

// Ogni login parte da una sessione pulita
session_regenerate_id(true);
unset($_SESSION["ID"], $_SESSION["nome"], $_SESSION["ruolo"], $_SESSION["admin"]);

// ============ LOGIN ADMIN ============
if (isset($_POST["admin"])) {

    $nome = "Admin";
    $password = (string) ($_POST["password"] ?? "");

    $stmt = mysqli_prepare($link, "SELECT id, nome, password, verifica, ruolo FROM utenza WHERE nome = ? LIMIT 1");
    if (!$stmt) {
        error_log("Errore SQL admin: " . mysqli_error($link));
        vaiA("server");
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    $risultato = mysqli_stmt_get_result($stmt);
    $utente = mysqli_fetch_assoc($risultato);
    mysqli_stmt_close($stmt);

    if (!$utente || !password_verify($password, $utente["password"])) {
        vaiA("credenziali");
    }

    if ((int) $utente["verifica"] !== 1) {
        vaiA("verifica");
    }

    $_SESSION["ID"]    = (int) $utente["id"];
    $_SESSION["nome"]  = $utente["nome"];
    $_SESSION["ruolo"] = "Admin";
    $_SESSION["admin"] = true;

    header("Location: admin/admin.php");
    exit;
}

// ============ LOGIN UTENTE ============
if (isset($_POST["login"])) {

    $nome = trim((string) ($_POST["name"] ?? ""));
    $password = (string) ($_POST["password"] ?? "");

    if ($nome === "" || $password === "") {
        vaiA("credenziali");
    }

    $stmt = mysqli_prepare($link, "SELECT id, nome, password, verifica, ruolo FROM utenza WHERE nome = ? LIMIT 1");
    if (!$stmt) {
        error_log("Errore SQL login: " . mysqli_error($link));
        vaiA("server");
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    $risultato = mysqli_stmt_get_result($stmt);
    $utente = mysqli_fetch_assoc($risultato);
    mysqli_stmt_close($stmt);

    // Stesso messaggio se l'utente non esiste o la password è errata
    if (!$utente || !password_verify($password, $utente["password"])) {
        vaiA("credenziali");
    }

    if ((int) $utente["verifica"] !== 1) {
        vaiA("verifica");
    }

    $_SESSION["ID"]    = (int) $utente["id"];
    $_SESSION["nome"]  = $utente["nome"];
    $_SESSION["ruolo"] = $utente["ruolo"];
    $_SESSION["admin"] = false;

    header("Location: employees/index.php");
    exit;
}

// ============ LOGIN ANONIMO ============
if (isset($_POST["anonymous"])) {

    $stmt = mysqli_prepare($link, "SELECT id, nome, ruolo FROM utenza WHERE nome = ? LIMIT 1");
    if (!$stmt) {
        error_log("Errore SQL anonimo: " . mysqli_error($link));
        vaiA("server");
    }

    $nomeAnonimo = "Anonimo";
    mysqli_stmt_bind_param($stmt, "s", $nomeAnonimo);
    mysqli_stmt_execute($stmt);
    $risultato = mysqli_stmt_get_result($stmt);
    $utente = mysqli_fetch_assoc($risultato);
    mysqli_stmt_close($stmt);

    if (!$utente) {
        vaiA("anonimo");
    }

    $_SESSION["ID"]    = (int) $utente["id"];
    $_SESSION["nome"]  = $utente["nome"];
    $_SESSION["ruolo"] = $utente["ruolo"];
    $_SESSION["admin"] = false;

    header("Location: employees/index.php");
    exit;
}

vaiA();