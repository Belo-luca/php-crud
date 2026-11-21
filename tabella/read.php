<?php
// Controlla l'esistenza del parametro id prima di procedere
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include il file di configurazione
    require_once "config.php";
    
    // Prepara un'istruzione select
    $sql = "SELECT * FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Associa le variabili all'istruzione preparata come parametri
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Imposta i parametri
        $param_id = trim($_GET["id"]);
        
        // Tenta di eseguire l'istruzione preparata
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Recupera la riga del risultato come array associativo. 
                   Dato che c'è una sola riga, non serve il ciclo while */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Recupera i valori dei singoli campi
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
            } else{
                // L'URL non contiene un ID valido. Reindirizza alla pagina di errore
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Chiude la dichiarazione
    mysqli_stmt_close($stmt);
    
    // Chiude la connessione
    mysqli_close($link);
} else{
    // L'URL non contiene il parametro id. Reindirizza alla pagina di errore
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p><b><?php echo $row["address"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p><b><?php echo $row["salary"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>