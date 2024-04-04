<?php
session_abort();
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = "educacon_educacon";
    $server = "localhost";
    $passWord = "De20por15te!";
    $database = "educacon_usersCCDS";
    $conexion = new mysqli($server, $user, $passWord, $database);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $nombre_usuario = $_POST['email'];
    $contrasena = $_POST['password'];

    $sql = "SELECT * FROM teacher WHERE email = '$nombre_usuario'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $hashed_password = $fila['pwd'];

        if ($contrasena == $hashed_password) {
            $mailNewLocation = $fila['email'];
            header("Location: ../user.php?email=$mailNewLocation");
            exit();
        } else {
            $_SESSION['mensaje'] = "CONTRASEÑA INCORRECTA. INTÉNTALO DE NUEVO";
        }
    } else {
        $_SESSION['mensaje'] = "Usuario no encontrado.";
    }

    $conexion->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        #header {
            cursor: pointer;
            text-align: center;
            border: 1px solid black;
            background-color: lightblue;
            color: white;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
            position: relative;
        }

        #header h1 {
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 700px;
            text-align: center;
            position: relative;
            box-sizing: border-box;
            margin-top: 20px; /* Ajuste de margen superior */
        }

        .form-container h2 {
            margin-bottom: 30px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .bottom-text {
            margin-top: 20px;
            color: #777;
        }

        #mensajeError {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <header id="header">
        <h1>Colegios Comprometidos con el Deporte y la Salud</h1>
    </header>
    <div class="form-container">
        <div id='dinamicText'></div>
        <script>
            var textoOriginal = "¡HOLA! INICIA SESIÓN CON LAS CLAVES PROPORCIONADAS POR LA ORGANIZACIÓN.";

            var elementoTexto = document.getElementById("dinamicText");

            var velocidadEscritura = 50;

            function mostrarTextoDinamico(texto, index, callback) {
                if (index < texto.length) {
                    elementoTexto.innerHTML += texto.charAt(index);
                    index++;
                    setTimeout(function () {
                        mostrarTextoDinamico(texto, index, callback);
                    }, velocidadEscritura);
                } else {
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            }
            mostrarTextoDinamico(textoOriginal, 0);
        </script>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="example@example.com" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Iniciar Sesión">
            </div>
        </form>
        <p class="bottom-text">¿Aún no tienes una cuenta? <a href="#">Regístrate aquí</a>.</p>
    </div>
    <div id="mensajeError">
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }
        ?>
    </div>
</body>

</html>

