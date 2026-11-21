<!--
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

/* Contenitore principale */
.login-box {
    width: 100%;
    max-width: 420px;
    background-color: white;
    border-radius: 14px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    overflow: hidden;
}

/* Intestazione */
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

/* Immagine */
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

/* Form */
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
    box-shadow: 0 0 4px rgba(4,170,109,0.25);
}

/* Pulsante login */
button {
    background-color: #04AA6D;
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

button:hover {
    background-color: #038f5b;
}

/* Ricordami */
.remember {
    display: flex;
    align-items: center;
    gap: 7px;
    font-weight: normal;
    font-size: 13px;
}

/* Footer */
.login-footer {
    background-color: #f7f8fa;
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}

.login-footer a {
    color: #04AA6D;
    text-decoration: none;
}

.login-footer a:hover {
    text-decoration: underline;
}

/* Smartphone */
@media screen and (max-width: 480px) {
    .login-box {
        max-width: 90%;
    }

    .container {
        padding: 20px;
    }
}
</style>
</head>
<body>
<div class="login-box">
    <div class="login-header">
        <h2>Benvenuto</h2>
        <p>Accedi al tuo account</p>
    </div>
    <div class="imgcontainer">
        <img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>
    <form id="loginForm" action="accedi.php" method="post">
        <div class="container">
            <label for="name">Nome utente</label>
            <input type="text" id="name" placeholder="Inserisci nome utente"
                   name="name" required>
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Inserisci password"
                   name="password" required>
            <button type="submit">Accedi</button>
        </div>
    </form>
</div>
    <script>
    fetch('messaggio.php')
        .then(risposta => risposta.json())
        .then(dati => {
            alert(dati.testo);
        })
    </script>
</body>
</html>

