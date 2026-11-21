<?php

//richiama il file per comunicare con il database
require_once "app/config.php";

//controllo per i vari utenti, se è anonimo, admin o un utente registrato
if (isset($_POST["anonymous"])) {
    // Se l'utente ha scelto di accedere come anonimo, esegui la query per verificare se l'utente "Anonimo" esiste
    $risultato = mysqli_query($link,"SELECT * FROM utenti WHERE nome = 'Anonimo'");

    // Controlla se la query ha avuto successo e indirizza
    if ($risultato === false) {
        die("Errore SQL: ".mysqli_error($link));
    }
    $utente = mysqli_fetch_assoc($risultato);
    if ($utente !== null) {
        header("Location: employees/index.php");
        exit;
    } else {
        echo "Utente anonimo non trovato!";
    }
}
else if (isset($_POST["admin"])){
    // Se l'utente ha scelto di accedere come admin, esegui la query per verificare se l'utente "admin" esiste
    $nome = "admin";
    $password = $_POST["password"];
    $prepara = mysqli_prepare($link,"SELECT * FROM utenza WHERE nome = 'admin'");
    if ($prepara === false) {
        die("Errore nella preparazione SQL: " . mysqli_error($link));
    }
    // Associa i parametri e esegui la query
    mysqli_stmt_execute($prepara);
    $risultato = mysqli_stmt_get_result($prepara);
    $utente = mysqli_fetch_assoc($risultato);
    if ($utente !== null) {
        if (password_verify($password, $utente["password"])) {
            header("Location: admin/admin.php");
            exit;
        } else {
            echo "Password errata!";
        }
    } else {
        echo "Utente non trovato!";
    }
    mysqli_stmt_close($prepara);
}else {

    $nome = trim($_POST["name"]);
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
            header("Location: employees/index.php");
            exit;
            }else{
                echo "Contatta l'amministratore per accedere!";
            }
        } else {
        header('Content-Type: application/json');

        echo json_encode([
            "testo" => "Benvenuto nel sito!"
        ]);
        }
    } else {
        echo "Utente non trovato!";
    }
    mysqli_stmt_close($prepara);
}
?>