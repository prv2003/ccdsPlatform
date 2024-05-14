<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location:forms/verifierLogin.php');
    exit();
}

$email = isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['userData']['email'];

include 'db.php';

$stmtVerifier = $conexion->prepare("SELECT * FROM verifier WHERE email = ?");
$stmtVerifier->bind_param("s", $email);
$stmtVerifier->execute();
$resultadoVerifier = $stmtVerifier->get_result();
$fila = $resultadoVerifier->fetch_assoc();

$nombreUsuario = $fila['name'];

$tiempoInactividad = 1800;

if (isset($_SESSION['ultima_actividad']) && (time() - $_SESSION['ultima_actividad']) > $tiempoInactividad) {
    session_unset();
    session_destroy();
    header("Location: forms/verifierLogin.php");
    exit();
}

$_SESSION['ultima_actividad'] = time();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCDS-Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #343a40 !important;
        }

        .navbar-brand {
            color: #ffffff !important;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
        }

        .section {
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Panel de Administración</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#dashboard" active>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#verificaciones">Gestionar Verificaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#usuarios">Gestionar Usuarios</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section id="dashboard">
        <div class="container mt-4">
            <!-- Contenido de la página -->
            <div id="dashboard" class="section">
                <div class="row">
                    <div class="col-md-4">
                        <div class="section">
                            <h4>Centros</h4>
                            <!-- Contenido de la sección de Centros -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="section">
                            <h4>Verificadores</h4>
                            <!-- Contenido de la sección de Verificadores -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="section">
                            <h4>Verificaciones</h4>
                            <!-- Contenido de la sección de Verificaciones -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS y dependencias jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>