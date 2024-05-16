<?php
session_start();
include ('db.php');
if (!(isset($_SESSION['email']))) {
    header('Location:forms/centerLogin.php');
    session_unset();
    session_destroy();
    exit();
}
$email = $_SESSION['email'];
$mensajeErr='';
$mensajeEquals='';

$tiempoInactividad = 1800;

if (isset($_SESSION['ultima_actividad']) && (time() - $_SESSION['ultima_actividad']) > $tiempoInactividad) {
    session_unset();
    session_destroy();
    header("Location: forms/centerLogin.php");
    exit();
}

$_SESSION['ultima_actividad'] = time();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = $conexion->prepare("SELECT * FROM teacher where email = ?");
    $sql->bind_param('s', $email);
    $sql->execute();
    $resultado = $sql->get_result();
    $filaTeacher = $resultado->fetch_assoc();

    $oldPwd = $_REQUEST['oldPwd'];
    if ($oldPwd != $filaTeacher['pwd']) {
        $mensajeErr = 'La contraseña actual no es correcta';
    }

    $newPwd = $_REQUEST['newPwd'];
    $confirm = $_REQUEST['confirmPwd'];
    if ($newPwd != $confirm) {
        $mensajeEquals = 'Las contraseñas deben coincidir';
    }

    if (empty($mensajeErr) && empty($mensajeEquals)) {
        $updateSql = $conexion->prepare("update teacher set pwd = ? where email = ?");
        $updateSql->bind_param('ss', $newPwd, $email);

        if ($updateSql->execute()) {
            echo "<script>alert('Contraseña modificada satisfactoriamente');</script>";
            session_unset();
            session_destroy();
            echo "<script>setTimeout(function() { window.location.href = 'user.php'; }, 1000);</script>";
            exit();
        } else {
            echo "<script>alert('La contraseña no se ha podido modificar');</script>";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de Contraseña</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            text-align: justify;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column; 
        }

        .alert {
            background-color: #ffc107;
            color: #333;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            width: 400px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }

        form {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .err{
            color: red;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .btnAtras {
            background-color: #555;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px; 
        }

        .btnAtras:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <header>
        <h1>Cambio de Contraseña</h1>
    </header>

    <main>
        <div class="alert">
            <p><strong>¡Atención!</strong> Una vez cambiada la contraseña, el cambio es permanente y no se puede deshacer.</p>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <label for="oldPwd">Contraseña Actual:</label>
            <input type="password" id="oldPwd" name="oldPwd" required>
            <p class='err'><?php echo $mensajeErr; ?></p>

            <label for="newPwd">Nueva Contraseña:</label>
            <input type="password" id="newPwd" name="newPwd" required>

            <label for="confirmPwd">Confirmar Nueva Contraseña:</label>
            <input type="password" id="confirmPwd" name="confirmPwd" required>
            <p class='err'><?php echo $mensajeEquals;?></p>

            <button type="submit">Cambiar Contraseña</button>
        </form>

        <button class="btnAtras" onclick="goBack()">Volver</button>
    </main>

    <footer>
        <p>&copy; 2024 Deporte para la Educación y la Salud (DES) - Programa CCDS</p>
    </footer>
</body>
</html>
<script>
    function goBack() {
        window.history.back();
    }
</script>
