<!--
Versione precedente non attiva della pagina.
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi</title>
</head>
<body>
    <h1>Registrati</h1>
    <form action="registrati.php" method="post">
        <label>Nome:</label>
        <input type="text" name="nome" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Registrati">
    </form>
    <hr>
    <h1>Accedi</h1>
    <form action="accedi.php" method="post">
        <label>Nome:</label>
        <input type="text" name="nome" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Accedi">
    </form>
    <hr>
    <h1>Admin</h1>
    <form action="accedi.php" method="post">
        <label>Nome:</label>
        <input type="text" name="nome" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Accedi" name="admin">
    </form>
    <hr>
    <h1>Accesso anonimo</h1>
    <form action="accedi.php" method="post">
        <button type="submit" name="anonymous" value="1">
            Accedi come anonimo
        </button>
    </form>
    <br>
    <a href="gestione_utenti.php">
    <button type="button">Gestione utenti</button>
    </a>
</body>
</html>-->


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <style>
        /* Regole globali e sfondo */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e8eef5, #cbd8e6);
        }

        /* Scheda di accesso */
        .login-box {
            width: 100%;
            max-width: 420px;
            background-color: white;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        .login-header {
            text-align: center;
            padding: 30px 20px 15px;
        }

        .login-header h2 {
            margin: 0;
            color: #263445;
            font-size: 26px;
        }

        .login-header p {
            color: #777;
            font-size: 14px;
        }

        .imgcontainer {
            text-align: center;
            padding: 10px;
        }

        img.avatar {
            width: 95px;
            height: 95px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #f1f1f1;
        }

        .container {
            padding: 20px 30px;
        }

        label {
            font-size: 14px;
            color: #333;
            font-weight: bold;
        }

        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 13px;
            margin: 8px 0 20px;
            display: inline-block;
            border: 1px solid #ddd;
            border-radius: 7px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #04AA6D;
            box-shadow: 0 0 4px rgba(4, 170, 109, 0.25);
        }

        /* Pulsanti della pagina */
        button {
            color: white;
            padding: 13px;
            margin: 10px 0;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }

        .button-accedi {
            background-color: #04AA6D;
        }

        .button-accedi:hover {
            background-color: #038f5b;
        }

        /* Pulsante di chiusura del popup */
        .close {
            position: absolute;
            z-index: 1;
            top: 10px;
            right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            margin: 0;
            padding: 0;
            border-radius: 50%;
            background: transparent;
            color: #263445;
            font-size: 30px;
            line-height: 1;
        }

        .close:hover,
        .close:focus {
            background-color: #f1f1f1;
            color: #038f5b;
        }

        /* Apertura e struttura del popup */
        .register-button {
            background-color: #526579;
        }

        .register-button:hover {
            background-color: #3e4d5e;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 2;
            inset: 0;
            overflow: auto;
            padding: 40px 0;
            background-color: rgba(32, 42, 55, 0.75);
        }

        .modal-content {
            position: relative;
            width: 80%;
            max-width: 520px;
            margin: 0 auto;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .signup-container {
            padding: 28px;
        }

        .signup-container h2 {
            margin-top: 0;
            color: #263445;
        }

        /* Pulsanti di annullamento e conferma */
        .modal-actions {
            display: flex;
            gap: 12px;
        }

        .modal-actions button {
            width: 50%;
        }

        .cancel-button {
            background-color: #f44336;
        }

        .cancel-button:hover {
            background-color: #d9362b;
        }

        /* Adattamento per schermi piccoli */
        @media screen and (max-width: 480px) {
            .login-box {
                max-width: 90%;
            }

            .container {
                padding: 20px;
            }

            .modal-content {
                width: 92%;
            }

            .signup-container {
                padding: 24px 20px;
            }
        }
    </style>
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
            <button type="button" class="register-button"
                onclick="document.getElementById('signupModal').style.display='block'">
                Crea un account
            </button>
            <button type="button" class="register-button"
                onclick="document.getElementById('AdminModal').style.display='block'">
                Area Admin
            </button>
        </div>
    </div>

    <!-- Form di registrazione nel popup -->
    <div id="signupModal" class="modal">
        <form class="modal-content" action="registrati.php" method="post" id="signupForm">
            <button type="button" class="close" aria-label="Chiudi"
                onclick="document.getElementById('signupModal').style.display='none'">&times;</button>
            <div class="signup-container">
                <h2>Registrati</h2>
                <p>Inserisci i dati per creare un account.</p>
                <hr>
                <label for="signup-name">Nome utente</label>
                <input type="text" id="signup-name" name="nome" placeholder="Inserisci nome utente" required>

                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="password" placeholder="Inserisci password" required>

                <label for="signup-password-repeat">Ripeti la password</label>
                <input type="password" id="signup-password-repeat" placeholder="Ripeti la password" required>

                <div class="modal-actions">
                    <button type="button" class="cancel-button"
                        onclick="document.getElementById('signupModal').style.display='none'">Annulla</button>
                    <button type="submit" class="button-accedi">Registrati</button>
                </div>
            </div>
        </form>
    </div>
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

    <!-- Controllo password e chiusura del popup -->
    <script>
        const signupModal = document.getElementById("signupModal");
        const signupForm = document.getElementById("signupForm");
        const signupPassword = document.getElementById("signup-password");
        const signupPasswordRepeat = document.getElementById("signup-password-repeat");

        // Verifica che le password siano uguali prima dell'invio.
        signupForm.addEventListener("submit", function(event) {
            if (signupPassword.value !== signupPasswordRepeat.value) {
                event.preventDefault();
                alert("Le password non coincidono.");
            }
        });

        // Chiude il popup cliccando sullo sfondo.
        window.addEventListener("click", function(event) {
            if (event.target === signupModal) {
                signupModal.style.display = "none";
            }
        });
    </script>
</body>

</html>