<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if(!isset($_SESSION['email'])){
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
$isMaster = ($fila['isMaster'] == 1) ? true : false;

$nombreUsuario = $fila['name'];
$passWord = $fila['pwd'];
$idVerifier = $fila['verifier_id'];
$org = $fila['org'];

$stmtOrg = $conexion->prepare("SELECT * FROM organization WHERE name = ?");
$stmtOrg->bind_param("i", $org);
$stmtOrg->execute();
$resultadoOrg = $stmtOrg->get_result();
$filaOrg = $resultadoOrg->fetch_assoc();

$nombreOrg = ($resultadoOrg->num_rows > 0) ? $filaOrg['name'] : 'Centro no encontrado';


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
    <title>Interfaz de Verificadores</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            text-align: justify;
        }

        header {
            background-color: #ff7f50; /* Naranja cálido para el encabezado */
            color: white;
            padding: 15px;
            text-align: center;
        }

        nav {
            background-color: #ff6348; /* Naranja un poco más oscuro para la barra de navegación */
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #ffa07a; /* Naranja más claro para los botones */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }

        .button:hover {
            background-color: #ff8c69; /* Naranja un poco más oscuro al pasar el cursor sobre los botones */
        }

        section {
            padding: 20px;
            margin: 20px 0;
        }

        article {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .master-access {
        background-color: #8a2be2; /* Puedes elegir el color que desees */
        color: white;
        }

        #misDatos{
            margin-bottom: 70px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            margin-top: 20px;
            background-color: #ff6348;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .general {
            background-color: lightgrey;
        }
    </style>
</head>
<body>
    <header>
        <h1>Interfaz de Usuario de <?php echo $nombreUsuario?></h1>
        <h2><?php echo $org?></h2>
    </header>
    
    <nav>
    <a href="#verificaciones" class="button">VERIFICACIONES</a>
    <a href="#misDatos" class="button">MIS DATOS</a>
    <a href="pwdChange.php" class="button">CAMBIAR CONTRASEÑA</a>
    <a href="mailto:prv@educacondeporte.org" class="button">CONTÁCTANOS</a>
    <a href="forms/verifierLogin.php" class="button">CERRAR SESIÓN</a>
    <?php
    if ($isMaster == true) echo '<a href="master.php" class="button master-access">MASTER</a>';
    ?>
    
</nav>
    
    <section id="verificaciones">
        <article>
            <h2>Verificaciones Realizadas</h2>
            <p>Detalles sobre las verificaciones realizadas por el verificador.</p>
        </article>
    </section>

    <section id="misDatos">
        <article>
            <h2>Mis Datos de Verificador</h2>
            <table>
                <tr>
                    <td class="general"><strong>DATOS DEL VERIFICADOR</strong></td>
                    <td class="general"></td>
                </tr>
                <tr>
                    <td>Nombre Completo:</td>
                    <td><?php echo $nombreUsuario; ?></td> 
                </tr>
                <tr>
                    <td>Correo electrónico:</td>
                    <td><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td>Contraseña de acceso:</td>
                    <td id="pwd"><strong><?php for ($i = 0; $i < mb_strlen($passWord, 'UTF-8'); $i++) echo '•'; ?></strong></td> 
                <tr>
                    <td class="general"><strong>DATOS DE LA ORGANIZACIÓN</strong></td>
                    <td class="general"></td>
                </tr>
                <tr>
                    <td>Nombre de la Organización:</td>
                    <td><?php echo $org; ?></td> 
                </tr>
                <tr>
                    <td>Localidad:</td>
                    <td><?php echo $filaOrg['ubicacion']; ?></td>
                </tr>
            </table>
        </article>
    </section>

    <footer>
        <p>&copy; 2024 Deporte para la Educación y la Salud (DES) - Programa CCDS</p>
    </footer>
</body>
</html>
