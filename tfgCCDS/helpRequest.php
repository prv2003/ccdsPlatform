<?php
if(isset($_POST['Enviar'])) {
    $nombre = $_POST['nombre'];
    $mail = $_POST['email'];
    $mensaje = $_POST['mensaje'];
    
    $header = 'From: ' . $mail . ' \r\n';
    $header .= 'X-Mailer: PHP/' . phpversion() . ' \r\n';
    $header .= 'Mime-Version 1.0 \r\n';
    $header .= 'Content-Type: text/plain';
    
    $mensaje = 'Este mensaje ha sido enviado por: ' . $nombre . ' ';
    $mensaje .= 'E-mail del emisor : ' . $mail . ' ';
    $mensaje .= 'Mensaje: ' . $_POST['mensaje'] . ' '; 
    $mensaje .= 'Enviado el ' . date('d/m/y',time());
    
    $para = 'atencion@educacondeporte.org';
    $asunto = 'HELP en plataforma CCDS';

    $email = mail($para, $asunto, $mensaje , $header);
    
    if(!$email) {
        echo '<script>alert("el correo no se pudo enviar");</script>';
        header('Location:index.php');
    } else {
        echo '<script>alert("el correo se envió correctamente");</script>';
        header ('Location:index.php');
    }
   
}
?>