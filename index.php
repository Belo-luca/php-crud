<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/index.css">
    <link rel="import" href="assets/index.js">
    <title>Login</title>
</head>
<body>
    <!-- Scheda e form di accesso -->
    <div class="login-box">
        <div class="login-header">
            <h2>Benvenuto</h2>
            <p>Accedi al tuo account</p>
        </div>
        <div class="imgcontainer">
            <img src="assets/img/Avatar.jpg" alt="Avatar" class="avatar">
        </div>
        <form id="loginForm" action="accedi.php" method="post">
            <div class="container">
                <label for="name">Nome utente</label>
                <input type="text" id="name" placeholder="Inserisci nome utente"
                    name="name" required>
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Inserisci password"
                    name="password" required>
                <button type="submit" class="button-accedi">Accedi</button>
            </div>
        </form>

        <!-- Apertura del popup di registrazione -->
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

    <!-- Form di registrazione nel popup -->
    <div id="signupModal" class="modal">
        <form class="modal-content" action="registrati.php" method="post" id="signupForm">
            <button type="button" class="close" aria-label="Chiudi" onclick="document.getElementById('signupModal').style.display='none'">&times;</button>
            <div class="signup-container">
                <h2>Registrati</h2>
                <p>Inserisci i dati per creare un account</p>
                <hr>
                <label for="signup-name">Nome utente</label>
                <input type="text" id="signup-name" name="nome" placeholder="Inserisci nome utente" required>

                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="password" placeholder="Inserisci password" required>

                <label for="signup-password-repeat">Ripeti la password</label>
                <input type="password" id="signup-password-repeat" placeholder="Ripeti la password" required>

                <label for="signup-crud">Scegli quello che vuoi fare</label>
                <div>
                    <input type="checkbox" id="modify" name="crud[]" value="modifica">
                    <label for="modify">Modifica</label>
                </div>
                <div>
                    <input type="checkbox" id="create" name="crud[]" value="crea">
                    <label for="create">Crea</label>
                </div>
                <div>
                    <input type="checkbox" id="delete" name="crud[]" value="elimina">
                    <label for="delete">Elimina</label>
                </div>

                <div class="modal-actions">
                    <button type="button" class="cancel-button"
                        onclick="document.getElementById('signupModal').style.display='none'">Annulla</button>
                    <button type="submit" class="button-accedi">Registrati</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Button admin -->
    <div id="AdminModal" class="modal">
        <form class="modal-content" action="admin/admin.php" method="post" id="adminForm">
            <button type="button" class="close" aria-label="Chiudi"
                onclick="document.getElementById('AdminModal').style.display='none'">&times;</button>
            <div class="signup-container">
                <h2>Area Admin</h2>
                <p>Accedi all'area di amministrazione.</p>
                <hr>
                <label for="signup-name">Nome utente</label>
                <input type="text" id="signup-name" name="nome" placeholder="Inserisci nome utente" required>

                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="password" placeholder="Inserisci password" required>

                <div class="modal-actions">
                    <button type="button" class="cancel-button"
                        onclick="document.getElementById('AdminModal').style.display='none'">Annulla</button>
                    <button type="submit" class="button-accedi">Accedi</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Avvisi restituiti dopo un tentativo di accesso -->
    <?php if (isset($_GET["errore"]) && $_GET["errore"] === "password"): ?>
        <script>
            alert("Password errata!");
            window.history.replaceState(null, "", window.location.pathname);
        </script>
    <?php elseif (isset($_GET["errore"]) && $_GET["errore"] === "verifica"): ?>
        <script>
            alert("Contatta l'amministratore per accedere!");
            window.history.replaceState(null, "", window.location.pathname);
        </script>
    <?php elseif (isset($_GET["errore"]) && $_GET["errore"] === "nome"): ?>
        <script>
            alert("Nome utente non trovato!");
            window.history.replaceState(null, "", window.location.pathname);
        </script>
    <?php elseif (isset($_GET["errore"]) && $_GET["errore"] === "utente"): ?>
        <script>
            alert("Nome già esistente!");
            window.history.replaceState(null, "", window.location.pathname);
        </script>
    <?php elseif (isset($_GET["errore"]) && $_GET["errore"] === "registrazione"): ?>
        <script>
            alert("Errore durante la registrazione!");
            window.history.replaceState(null, "", window.location.pathname);
        </script>
    <?php endif; ?>
</body>
</html>