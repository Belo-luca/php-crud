<?php
// Create a database connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 
if (!isset($_SESSION["ruolo"])) {
    header("Location: ../login.php");
    exit;
}

$ruolo = $_SESSION["ruolo"];

// Definisce le variabili e le inizializza con valori vuoti
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Elabora i dati del modulo quando viene inviato (metodo POST)
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Ottiene il valore dell'input nascosto (id)
    $id = $_POST["id"];
    
    // Convalida il nome
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Convalida l'indirizzo
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Convalida lo stipendio
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Controlla gli errori prima di aggiornare il database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepara un'istruzione di aggiornamento (UPDATE)
        $sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Associa le variabili come parametri
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            
            // Imposta i parametri
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;
            
            // Tenta di eseguire l'istruzione preparata
            if(mysqli_stmt_execute($stmt)){
                // Aggiornamento riuscito. Reindirizza alla dashboard
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Chiude la dichiarazione
        mysqli_stmt_close($stmt);
    }
    
    // Chiude la connessione
    mysqli_close($link);
    
} else{
    // Se non è un POST, controlla l'esistenza del parametro id nell'URL (GET)
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id = trim($_GET["id"]);
        
        // Prepara l'istruzione select per leggere i dati attuali
        $sql = "SELECT * FROM employees WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Memorizza i vecchi valori nelle variabili per mostrarli nel form
                    $name = $row["name"];
                    $address = $row["address"];
                    $salary = $row["salary"];
                } else{
                    // ID non valido nell'URL, reindirizza all'errore
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }  else{
        // Nessun ID trovato, reindirizza all'errore
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>