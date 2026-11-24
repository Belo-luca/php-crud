<?php
// Elabora l'operazione di eliminazione dopo la conferma
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include il file di configurazione
    require_once __DIR__ . "/../app/config.php";
    
    // Prepara un'istruzione di eliminazione (DELETE)
    $sql = "DELETE FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Associa le variabili all'istruzione preparata come parametri
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Imposta i parametri
        $param_id = trim($_POST["id"]);
        
        // Tenta di eseguire l'istruzione preparata
        if(mysqli_stmt_execute($stmt)){
            // Record eliminato con successo. Reindirizza alla dashboard
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Chiude la dichiarazione
    mysqli_stmt_close($stmt);
    
    // Chiude la connessione
    mysqli_close($link);
} else{
    // Controlla l'esistenza del parametro id nell'URL
    if(empty(trim($_GET["id"]))){
        // L'URL non contiene l'id, reindirizza alla pagina di errore
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{ width: 600px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this employee record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>