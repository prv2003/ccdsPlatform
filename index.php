<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCDS Verificaciones</title>
    <style>
    #header {
    text-align: center;
    border: 1px solid black;
    background-color: lightblue;
    color: white;
    padding: 20px;
}

footer {
    width: 100%;
    margin-top: auto;
    text-align: center;
}
#divEliminar{
    height: 30px;
}
.left-image {
    float: left;
    margin-right: 10px;
}
#formulario{
    margin: auto;
    align-items: center;
}
.right-image {
    float: right;
    margin-left: 10px;
}

#bienvenida {
    width: 1000px;
    text-align: center;
    margin: 10px auto; 
}

.container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin: 10px auto; 
}
.container2 {
    align-items: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin: 10px auto;
}
.container3{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin: 10px auto; 
}
.opt{
    cursor: pointer;
    background-color: rgb(177, 207, 233);
    padding: 20px;
    margin-left: auto;
    width: 460px;
    height: 160px;
    text-align: center;
    border-radius: 4px;
    float: left;
}
#opt1{

    background-image: url(opt1img.png);
    background-repeat: no-repeat;
}
#opt2{
    margin-left: 20px;
    background-image: url(opt2img.png);
    background-repeat: no-repeat;
}

.help {
    cursor: pointer;
    width: 35%;
    background-image: url(HELPimg.png);
    background-repeat: no-repeat;
    padding: 20px;
    text-align: center;
    margin-top: 10px;
    border-radius: 4px;
    margin: 10px auto;
    height: 160px;
}
#disclaimer{
    text-align: center;  
    margin-top: 10px;
    margin-bottom: 10px;
}


form{
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    margin: 5px;
    margin-top: -30px;
    align-items: center;
    height: 200px;
    width: 350px;
    background-color: rgb(203, 245, 247);
    padding: 20px;
    border-radius: 8px;
}

label {
    display: block;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
}

input[type="submit"]{
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
}

input[type="submit"]:hover{
background-color: #45a049;
}

textarea{
    min-height: 20px; /* Altura mínima del textarea */
    max-height: 30px; /* Altura máxima del textarea */
    width: 100%; /* Ajusta el ancho según sea necesario */
}
</style>
</head>
<body>
    <header id="header">
        <h1>Colegios Comprometidos con el Deporte y la Salud</h1>
    </header>
    <div class="img">
        <img src="imgs float left TFG.png" alt="Imagen Izquierda" class="left-image" height="700">
        <img src="imgs float right TFG.png" alt="Imagen Derecha" class="right-image" height="700">
    </div>
    <div class="container">
        <div id="bienvenida">
            <h2>¡Bienvenido al programa de verificaciones!<br> Por favor, para continuar elige 
            una de las siguientes opciones. <br>Si necesitas asistencia, pulsa en el botón 'Tengo un problema'
            </h2>
        </div>
    </div>
    <div class="container2">
        <div class="options">
            <div id='opt1' class="opt"></div>
            <div id='opt2' class="opt"></div>
        </div>
    </div>
    <div class="container3" id="container3">
        <div class="help" id = "ayuda"></div>
    </div>
    <div id="disclaimer"><b>¡DISCLAIMER!:</b> Esta aplicación web aún está en desarrollo y no es funcional. Deporte
    para la Educación y la Salud no se hace responsable de posibles daños ocasionados en caso de uso de la plataforma
    antes del lanzamiento oficial. 
    </div>
    <div id="divEliminar"></div>
    <footer id="footer">
        <strong><p>&copy; 2023 Deporte para la Educación y la Salud (DES) - Programa CCDS</p></strong>
    </footer>
	<script>
	console.log("Inicio de script");
	document.addEventListener('DOMContentLoaded', function() {
        var eles = document.getElementsByClassName('help');
        for (let ele of eles) { 
            ele.addEventListener('click', ayuda);
		}
		let contador=0;
        var cont1=document.getElementById('opt1');
        var cont2=document.getElementById('opt2');
        cont1.addEventListener('click',soyUnCentro);
        cont2.addEventListener('click',soyVerificador);
		function ayuda() {
            contador++;
			console.log("Inicio de función ayuda con contador en: " + contador);
            if(!(contador % 2 == 0)){
            var divDelete = document.getElementById('divEliminar');
            console.log("Div a eliminar guardado en variableDivDelete" + divDelete);
            divDelete.remove();
			var elem = document.createElement('div');
			elem.id = 'newDiv';
            elem.style.width="600px";
            elem.style.height="350px";
            elem.style.display="flex";
            elem.style.alignItems="center";
            elem.style.justifyContent="center";
            elem.style.margin="auto";
			var formulario = document.createElement('form');  
            formulario.method = 'post';
            formulario.action = 'helpRequest.php';
            formulario.style.alignSelf="center";

            formulario.innerHTML = `
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required><br>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>
                
                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="4" required></textarea><br>
                
                <input type="submit" value="Enviar" name="Enviar">
            `;

            elem.appendChild(formulario);
            var divContenedor = document.getElementById('container3');

            // Verificar si divAyuda existe antes de insertar
            if (divContenedor) {
                // Insertar elem justo después de divAyuda
                divContenedor.parentNode.insertBefore(elem, divContenedor.nextSibling);
            } else {
                // Si divAyuda no se encuentra, simplemente agregar elem al final del body
                document.body.appendChild(elem);
            }
			} else {
                var divContenedor = document.getElementById('disclaimer');
                console.log("estoy pasando por el bucle impar");
                var ele = document.getElementById('newDiv');
                ele.remove();
                var divEspacio =document.createElement('div');
                divEspacio.id = 'divEliminar';
                divEspacio.style.height = '30px';
                divContenedor.parentNode.insertBefore(divEspacio,divContenedor);
            }
        }
        function soyUnCentro(){
            window.location.href = 'forms/centerLogin.php';
            <?php 
            // header('Location:centerLogin.php');    
            ?>
        }
        function soyVerificador(){
            window.location.href = 'forms/verifierLogin.php';
            <?php
            //header('Location:verifierLogin.php');
            ?>
        }

    });
</script>

</body>
</html>
<?php

/*
include_once 'config/user.php'; 
include_once 'config/user_session.php';

$userSession = new UserSession();
$user = new User();

if(isset($_SESSION['user'])){
    echo "Hay sesión";
} else if(isset($_POST['username'] && isset($_POST['password']))){
    echo "Validación de login";
} else {
    echo "Login";
    include_once "view/home/login.php";
}*/
?>
