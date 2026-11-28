<?php
session_start();

$messaggi = [
    "password"       => "Password non valida.",
    "credenziali"    => "Credenziali non valide.",
    "verifica"       => "Account non ancora approvato. Contatta l'amministratore.",
    "anonimo"        => "Accesso anonimo non disponibile.",
    "sessione"       => "Sessione scaduta o non valida. Effettua di nuovo l'accesso.",
    "accesso_negato" => "Non hai i permessi per accedere a quest'area.",
    "registrazione"  => "Errore durante la registrazione.",
    "utente"         => "Nome utente già esistente.",
    "server"         => "Errore del server. Riprova più tardi.",
];

$errore = $_GET["errore"] ?? null;
$testoErrore = ($errore !== null && isset($messaggi[$errore])) ? $messaggi[$errore] : null;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/index.css">
    <title>Login</title>
</head>
<body>

    <div class="login-box">
        <div class="login-header">
            <h2>Benvenuto</h2>
            <p>Accedi al tuo account</p>
        </div>
        <div class="imgcontainer">
            <img src="assets/img/Avatar.jpg" alt="Avatar" class="avatar">
        </div>

        <form id="loginForm" action="accedi.php" method="post">
            <input type="hidden" name="login" value="1">
            <div class="container">
                <label for="name">Nome utente</label>
                <input type="text" id="name" placeholder="Inserisci nome utente" name="name" required autocomplete="username">

                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Inserisci password" name="password" required autocomplete="current-password">

                <button type="submit" class="button-accedi">Accedi</button>
            </div>
        </form>

        <div class="container">
            <button type="button" class="register-button" onclick="document.getElementById('signupModal').style.display='block'">
                Crea un account
            </button>
            <button type="button" class="register-button" onclick="document.getElementById('AdminModal').style.display='block'">
                Area Admin
            </button>
            <form action="accedi.php" method="post">
                <button type="submit" class="register-button" name="anonymous" value="1">
                    Accedi come anonimo
                </button>
            </form>
        </div>
    </div>

    <!-- Registrazione -->
    <div id="signupModal" class="modal">
        <form class="modal-content" action="registrati.php" method="post" id="signupForm">
            <button type="button" class="close" aria-label="Chiudi" onclick="document.getElementById('signupModal').style.display='none'">&times;</button>
            <div class="signup-container">
                <h2>Registrati</h2>
                <p>Inserisci i dati per creare un account. L'accesso sarà attivo dopo l'approvazione dell'amministratore.</p>
                <hr>
                <label for="signup-name">Nome utente</label>
                <input type="text" id="signup-name" name="nome" placeholder="Inserisci nome utente" required autocomplete="off">

                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="password" placeholder="Inserisci password" autocomplete="new-password">

                <label for="signup-password-repeat">Ripeti la password</label>
                <input type="password" id="signup-password-repeat" name="password_ripeti" placeholder="Ripeti la password" autocomplete="new-password">

                <label for="ruolo">Ruolo</label>
                <select id="ruolo" name="ruolo" required>
                    <option value="1">Utente (vedi i dati)</option>
                    <option value="2">Dipedente (vedi e aggiungi dati)</option>
                    <option value="3">Admin (vedi, aggiungi e modifica dati)</option>
                    <option value="4">Re del mondo (vedi, aggiungi, modifica e elimina dati)</option>
                </select>
                <div class="modal-actions">
                    <button type="button" class="cancel-button" onclick="document.getElementById('signupModal').style.display='none'">Annulla</button>
                    <button type="submit" class="button-accedi">Registrati</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Area admin -->
    <div id="AdminModal" class="modal">
        <form class="modal-content" action="accedi.php" method="post" id="adminForm">
            <input type="hidden" name="admin" value="1">
            <button type="button" class="close" aria-label="Chiudi" onclick="document.getElementById('AdminModal').style.display='none'">&times;</button>
            <div class="signup-container">
                <h2>Area Admin</h2>
                <p>Accedi all'area di amministrazione.</p>
                <hr>
                <label for="admin-password">Password</label>
                <input type="password" id="admin-password" name="password" placeholder="Inserisci password" required autocomplete="current-password">

                <div class="modal-actions">
                    <button type="button" class="cancel-button" onclick="document.getElementById('AdminModal').style.display='none'">Annulla</button>
                    <button type="submit" class="button-accedi">Accedi</button>
                </div>
            </div>
        </form>
    </div>

    <?php if ($testoErrore !== null): ?>
        <script>
            alert(<?= json_encode($testoErrore, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>);
            window.history.replaceState(null, "", window.location.pathname);
        </script>
    <?php endif; ?>
</body>
</html>