<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtro</title>
</head>

<body>
    <form method="GET" action="filtro.php">
        <input type="number" name="id" placeholder="ID esatto">
        <input type="text" name="name" placeholder="Nome">
        <input type="text" name="address" placeholder="Indirizzo">
        <input type="number" step="1" name="salary" placeholder="Salario">
        <button type="submit">Cerca</button>
    </form>
</body>

</html>