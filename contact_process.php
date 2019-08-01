<?php
require 'PHPMailerAutoload.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');
// Debes editar las próximas dos líneas de código de acuerdo con tus preferencias
//$email_to = "sdesigncba@gmail.com";
//$email_to = "carlosdanielgutierrez@gmail.com";


// $email_to ="info@ralseff.com";

$name = $_REQUEST['name'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];
$msj = $_REQUEST['consulta'];


$email_subject = "Consulta campaña Ralseff marzo";

// Aquí se deberían validar los datos ingresados por el usuario
if(!isset($_POST['name']) ||
!isset($_POST['phone']) ||
!isset($_POST['email']) ||
!isset($_POST['consulta'])) {

echo "<b>Ocurrió un error y el formulario no ha sido enviado. </b><br />";
echo "Por favor, vuelva atrás y verifique la información ingresada<br />";
die();
}

$email_message = "Detalles del formulario :\n\n";
$email_message .= "Nombre: " . $_POST['name'] . "\n";
$email_message .= "Teléfono: " . $_POST['phone'] . "\n";
$email_message .= "Mensaje: " . $_POST['consulta'] . "\n";
$email_message2 = "<h1>Detalles del formulario :</h1><br>";
$email_message2 .= "<p>Nombre y Apellido: " . $_POST['name'] ."</p>";
$email_message2 .= "<p>Teléfono: " . $_POST['phone'] ."</p>";
$email_message2 .= "<p>E-mail: " . $_POST['email'] ."</p>";
$email_message2 .= "<p>Mensaje: " . $_POST['consulta'] ."</p>";

//inicio script grabar datos en csv
$fichero = 'Curso cirugía mamaria.csv';//nombre archivo ya creado
//crear linea de datos separado por coma
$fecha=date("d-m-y H:i:s");
// $hora=date("H:i:s");
$linea = $fecha.";".$name.";".$phone.";".$email.";".$msj."\n";
// Escribir la linea en el fichero
file_put_contents($fichero, $linea, FILE_APPEND | LOCK_EX);
//fin grabar datos
// $message=$message.' local='.$local;
// $mail = new PHPMailer;
// $mail->isSMTP();

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';

$mail->Host = 'smtp.cursocirugiamamaria.com';
$mail->Port = 2525;
$mail->SMTPSecure = '';
$mail->SMTPAuth = true;
$mail->Username = 'info-cursocirugiamamaria.com';
$mail->Password = 'CCM951789';
$mail->setFrom('info@cursocirugiamamaria.com', 'Hospital Rawson');

$mail->addReplyTo('info@cursocirugiamamaria.com','Hospital Rawson');
$mail->addAddress('sprados@chimpancedigital.com.ar','Hospital Rawson');
// $mail->addCc('ralseff@chimpancedigital.com.ar','chimpance');
$mail->isHTML(true);
$mail->Subject = $email_subject;
$mail->Body    = $email_message2;
$mail->AltBody = $email_message;

$mail->CharSet = 'UTF-8';
if (!$mail->send()) {
    $mail_enviado=false;
    $mail_error .= 'Mailer Error: '.$mail->ErrorInfo;
} else {
    $mail_enviado=true;
    $mail_error='Mensaje Enviado, Gracias';
}
// Ahora se envía el e-mail usando la función mail() de PHP
//$headers = 'From: Ralseff <info@ralseff.com>' . "\r\n" .
//    'Reply-To: noreply@ralseff.com' . "\r\n" .
//    'Cc: ralseff@chimpancedigital.com.ar' . "\r\n" .
//    'X-Mailer: PHP/' . phpversion();
//$mail_enviado = @mail($email_to, utf8_decode($email_subject), utf8_decode($email_message), $headers);


if($mail_enviado)
{
echo "<script>location.href='gracias.html';</script>";

}
else
{
	echo "no se pudo enviar" ;
}

// Envia un e-mail para el remitente, agradeciendo la visita en el sitio, y diciendo que en breve el e-mail sera respondido. 
// $mensaje2  = "Hola" . $_POST['name'] . ". Gracias por contactarnos. Un asesor se comunicará con usted a la brevedad..."; 
// $mensaje2 .= "PD - No es necesario responder este mensaje."; 
// $envia =  mail($_POST['email'],"Su mensaje fué recibido!",$mensaje2,$headers);



?>