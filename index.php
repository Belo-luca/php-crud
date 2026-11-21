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
</html>