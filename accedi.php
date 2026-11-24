<?php

//richiama il file per comunicare con il database
require_once "app/config.php";
session_start();
//controllo per i vari utenti, se è anonimo, admin o un utente registrato
if (isset($_POST["anonymous"])) {
    // Se l'utente ha scelto di accedere come anonimo, esegui la query per verificare se l'utente "Anonimo" esiste
    $risultato = mysqli_query($link, "SELECT * FROM utenza WHERE nome = 'Anonimo'");

    // Controlla se la query ha avuto successo e indirizza
    if ($risultato === false) {
        header("Location: index.php?errore=anonimo");
    }
    $utente = mysqli_fetch_assoc($risultato);
    if ($utente !== null) {
        header("Location: employees/index.php");
        exit;
    } else {
        header("Location: index.php?errore=anonimo");
        }
} else if (isset($_POST["admin"])) {
    // Se l'utente ha scelto di accedere come admin, esegui la query per verificare se l'utente "admin" esiste
    $nome = "admin";
    $password = $_POST["password"];
    $prepara = mysqli_prepare($link, "SELECT * FROM utenza WHERE nome = 'admin'");
    if ($prepara === false) {
        die("Errore nella preparazione SQL: " . mysqli_error($link));
    }
    // Associa i parametri e esegui la query
    mysqli_stmt_execute($prepara);
    $risultato = mysqli_stmt_get_result($prepara);
    $utente = mysqli_fetch_assoc($risultato);

    // Controlla se l'utente admin esiste e verifica la password
    if ($utente !== null) {
        if (password_verify($password, $utente["password"])) {
            header("Location: admin/admin.php");
            exit;
        } else {
            header("Location: index.php?errore=password");
            exit;
        }
    } else {
        echo "Utente non trovato!";
    }
    mysqli_stmt_close($prepara);
} else {

    $nome = trim($_POST["name"]);
    $password = $_POST["password"];
    $prepara = mysqli_prepare($link, "SELECT * FROM utenza WHERE nome = ?");
    if ($prepara === false) {
        die("Errore nella preparazione SQL: " . mysqli_error($link));
    }
    mysqli_stmt_bind_param($prepara, "s", $nome);
    mysqli_stmt_execute($prepara);
    $risultato = mysqli_stmt_get_result($prepara);
    $utente = mysqli_fetch_assoc($risultato);
    if ($utente !== null) {
        if (password_verify($password, $utente["password"])) {
            if ($utente["verifica"] == 1) {
<<<<<<< HEAD
                $_SESSION["ID"] = $utente["ID"];
                $_SESSION["nome"] = $utente["nome"];
                $_SESSION["ruolo"] = $utente["ruolo"];

=======
                session_regenerate_id(true);
                $_SESSION["ID"] = $utente["ID"];
                $_SESSION["nome"] = $utente["nome"];
                $_SESSION["ruolo"] = $utente["ruolo"];
>>>>>>> fc82671ee261ab233210e5a541102ab6558f9c48
                header("Location: employees/index.php");
                exit;
            } else {
                header("Location: index.php?errore=verifica");
            }
        } else {
            header("Location: index.php?errore=password");
            exit;
        }
    } else {
        header("Location: index.php?errore=nome");
        exit;
    }
    mysqli_stmt_close($prepara);
}
