
<?php
session_start();

require_once __DIR__ . "/../app/config.php";

// Controllo autenticazione
if (!isset($_SESSION["ruolo"])) {
    header("Location: ../login.php");
    exit;
}

$ruolo = (string) $_SESSION["ruolo"];

// Recupera i dipendenti
$sql = "SELECT * FROM employees ORDER BY id DESC";
$result = mysqli_query($link, $sql);

if (!$result) {
    die("Errore nel recupero dei dipendenti.");
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard | Employees</title>

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .wrapper {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .dashboard-header {
            margin-top: 30px;
            margin-bottom: 25px;
        }

        .dashboard-header h2 {
            font-weight: 600;
            color: #343a40;
        }

        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        table tr td:last-child {
            width: 120px;
            text-align: center;
        }

        .table th {
            background-color: #f1f3f5;
        }

        .action-icon {
            font-size: 17px;
            text-decoration: none !important;
        }

        /* MODAL REGISTRAZIONE */

        #filterModal .modal-content {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
        }

        #filterModal .modal-header {
            background-color: #198754;
            color: white;
            padding: 20px 25px;
        }

        #filterModal .modal-title {
            font-weight: 600;
        }

        #filterModal .close {
            color: white;
            opacity: 0.9;
            text-shadow: none;
        }

        #filterModal .modal-body {
            padding: 25px;
        }

        #filterModal .form-group {
            margin-bottom: 20px;
        }

        #filterModal label {
            font-weight: 600;
            color: #444;
        }

        #filterModal .form-control {
            border-radius: 6px;
            height: auto;
            padding: 10px 12px;
        }

        #filterModal .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
        }

        #filterModal .modal-footer {
            padding: 15px 25px;
            background-color: #f8f9fa;
        }

        #filterModal .btn {
            border-radius: 6px;
            padding: 9px 18px;
        }

        @media (max-width: 600px) {
            .dashboard-header {
                align-items: flex-start !important;
                flex-direction: column;
            }

            .dashboard-buttons {
                margin-top: 15px;
                flex-wrap: wrap;
            }

            .wrapper {
                padding: 10px;
            }
        }
    </style>

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</head>

<body>

<div class="wrapper">

    <div class="container-fluid">
        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Employees Details</h2>
            <div class="dashboard-buttons d-flex align-items-center">
                <?php if ($ruolo === "4" || $ruolo === "3"): ?>

                    <a href="create.php" class="btn btn-success mr-2">
                        <i class="fa fa-plus"></i>
                        Add New Employee
                    </a>
                <?php endif; ?>
                    <button type="button"
                            class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#filterModal">

                        <i class="fa fa-user-plus"></i>
                        Register
                    </button>
            </div>
        </div>

        <div class="table-container">

            <?php if (mysqli_num_rows($result) > 0): ?>

                <table class="table table-bordered table-striped table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Salary</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php while ($row = mysqli_fetch_assoc($result)): ?>

                            <tr>

                                <td>
                                    <?php echo htmlspecialchars($row["id"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row["name"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row["address"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row["salary"]); ?>
                                </td>

                                <td>
                                    <a href="read.php?id=<?php echo (int)$row["id"]; ?>"
                                       class="mr-3 action-icon"
                                       title="Visualizza"
                                       data-toggle="tooltip">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <?php if ($ruolo === "3" || $ruolo === "4"): ?>
                                        <a href="update.php?id=<?php echo (int)$row["id"]; ?>"
                                           class="mr-3 action-icon"
                                           title="Modifica"
                                           data-toggle="tooltip">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($ruolo === "4"): ?>
                                        <a href="delete.php?id=<?php echo (int)$row["id"]; ?>"
                                           class="action-icon text-danger"
                                           title="Elimina"
                                           data-toggle="tooltip">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fa fa-info-circle"></i>
                    Nessun dipendente trovato.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- MODAL REGISTRAZIONE -->
<div class="modal fade"
     id="filterModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="signupTitle"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">

                <h5 class="modal-title" id="signupTitle">
                    <i class="fa fa-user-plus"></i>
                    Filtra utenti
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Chiudi">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>


            <!-- FORM -->
            <form action="registrati.php" method="POST" id="signupForm">

            <form method="GET" action="filtro.php">
        <input type="text" name="nome" placeholder="Titolo o autore">
        <input type="number" step="1" name="salary" placeholder="Salario">
        <button type="submit">Cerca</button>
    </form>
                <div class="modal-body">
                    <p class="text-muted">
                        Inserisci i dati per filtrare i risultati
                    </p>
                    <hr>
                    <div class="form-group">
                        <label for="signup-id">
                            Id
                        </label>
                        <input type="number"
                               class="form-control"
                               id="number"
                               name="id"
                               placeholder="Inserisci l'id esatto dell'utenete da vedere">
                    </div>
                    <div class="form-group">
                        <label for="signup-address">
                            Indirizzo
                        </label>
                        <input type="text"
                               class="form-control"
                               id="address"
                               name="address"
                               placeholder="Inserisci l'indirizzo dell'utenete da vedere"
                               >
                        </div>
                    <div class="form-group">
                        <label for="signup-password-repeat">
                            Conferma password
                        </label>
                        <input type="password"
                               class="form-control"
                               id="signup-password-repeat"
                               name="password_ripeti"
                               placeholder="Ripeti la password"
                               required
                               autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label for="ruolo">
                            Ruolo utente
                        </label>
                        <select class="form-control"
                                id="ruolo"
                                name="ruolo"
                                required>
                            <option value="1">
                                Utente - Visualizzazione
                            </option>
                            <option value="2">
                                Dipendente - Visualizzazione
                            </option>
                            <option value="3">
                                Admin - Modifica dati
                            </option>
                            <option value="4">
                                Amministratore - Controllo completo
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Annulla
                    </button>
                    <button type="submit"
                            class="btn btn-success">

                        <i class="fa fa-check"></i>
                        Registrati

                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($link);
?>
