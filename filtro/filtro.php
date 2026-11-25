<?php
require_once __DIR__ . "/../app/config.php";

$sql = "SELECT id, name, address, salary FROM utenti WHERE 1=1";
$types = "";
$params = [];

if (isset($_GET['id']) && $_GET['id'] !== '' && is_numeric($_GET['id'])) {
    $sql .= " AND id = ?";
    $types .= "i";
    $params[] = (int) $_GET['id'];
}

if (isset($_GET['name']) && trim($_GET['name']) !== '') {
    $sql .= " AND name LIKE ?";
    $types .= "s";
    $params[] = '%' . trim($_GET['name']) . '%';
}

if (isset($_GET['address']) && trim($_GET['address']) !== '') {
    $sql .= " AND address LIKE ?";
    $types .= "s";
    $params[] = '%' . trim($_GET['address']) . '%';
}

if (isset($_GET['salary']) && $_GET['salary'] !== '' && is_numeric($_GET['salary'])) {
    $sql .= " AND salary = ?";
    $types .= "i";
    $params[] = (int) $_GET['salary'];
}

$stmt = mysqli_prepare($link, $sql);
if ($stmt === false) {
    die("Errore nella preparazione della query: " . mysqli_error($link));
}

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$righe = [];
while ($row = mysqli_fetch_assoc($result)) {
    $righe[] = $row;
}

mysqli_stmt_close($stmt);
