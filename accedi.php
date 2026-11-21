<?php
require_once "tabella/config.php";
if (isset($_POST["anonymous"])) {
    $risultato = mysqli_query($link,"SELECT * FROM utenti WHERE nome = 'Anonimo'");
    if ($risultato === false) {
        die("Errore SQL: ".mysqli_error($link));
    }
    $utente = mysqli_fetch_assoc($risultato);
    if ($utente !== null) {
        header("Location: tabella/index.php");
        exit;
    } else {
        echo "Utente anonimo non trovato!";
    }
}
else if (isset($_POST["admin"])){
    $nome = "admin";
    $password = $_POST["password"];
    $prepara = mysqli_prepare($link,"SELECT * FROM utenza WHERE nome = 'admin'");
    if ($prepara === false) {
        die("Errore nella preparazione SQL: " . mysqli_error($link));
    }
    mysqli_stmt_execute($prepara);
    $risultato = mysqli_stmt_get_result($prepara);
    $utente = mysqli_fetch_assoc($risultato);
    if ($utente !== null) {
        if (password_verify($password, $utente["password"])) {
            header("Location: admin.php");
            exit;
        } else {
            echo "Password errata!";
        }
    } else {
        echo "Utente non trovato!";
    }
    mysqli_stmt_close($prepara);
}else {
    $nome = trim($_POST["nome"]);
    $password = $_POST["password"];
    $prepara = mysqli_prepare($link,"SELECT * FROM utenza WHERE nome = ?");
    if ($prepara === false) {
        die("Errore nella preparazione SQL: " . mysqli_error($link));
    }
    mysqli_stmt_bind_param($prepara, "s", $nome);
    mysqli_stmt_execute($prepara);
    $risultato = mysqli_stmt_get_result($prepara);
    $utente = mysqli_fetch_assoc($risultato);
    if ($utente !== null) {
        if (password_verify($password, $utente["password"])) {
            if($utente["verifica"] == 1) {
            header("Location: tabella/index.php");
            exit;
            }else{
                echo "Contatta l'amministratore per accedere!";
            }
        } else {
            echo "Password errata!";
        }
    } else {
        echo "Utente non trovato!";
    }
    mysqli_stmt_close($prepara);
}
?>